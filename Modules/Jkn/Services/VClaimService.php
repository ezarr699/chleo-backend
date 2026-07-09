<?php
/**
 * ============================================================
 * @module      Jkn
 * @layer       Service
 * @file        VClaimService.php
 * @path        Modules/Jkn/Services/VClaimService.php
 * @description Bridging nyata ke BPJS V-Claim lewat package
 *              indravscode/bridging-bpjs (Bridging\Bpjs\VClaim\Peserta &
 *              Sep). Setiap panggilan (sukses maupun gagal) dicatat lewat
 *              Shared\Contracts\IntegrationLoggerInterface (INT-01) —
 *              gagal otomatis memicu notifikasi admin (INT-01-3) dan
 *              tercatat di dashboard log_integrasi untuk ditindaklanjuti
 *              (INT-01-2). buatSep() membaca & menulis Kunjungan lewat
 *              Shared\Contracts\KunjunganStatusInterface — TIDAK PERNAH
 *              mengimpor Model Kunjungan (Modul Registrasi) — dan
 *              mengembalikan array polos (bukan Model), supaya Controller
 *              tidak butuh Resource yang membungkus Model lintas modul.
 *              Sengaja bukan `final` dan tanpa interface terpisah — test
 *              mem-Mockery::mock() class ini langsung (lihat
 *              Tests/Feature/VClaimTest.php), pola yang sama dengan
 *              Modules/Auth/Repositories/AuthRepository.php.
 *
 *              PENTING — struktur payload SEP: package ini cuma
 *              meneruskan array mentah ke API BPJS (tidak mendefinisikan
 *              field-nya sendiri), jadi struktur `request.t_sep` di
 *              buildSepPayload() disusun berdasarkan struktur SEP/1.1
 *              yang umum didokumentasikan publik (noKartu, tglSep,
 *              ppkPelayanan, jnsPelayanan, klsRawat, poli, rujukan, dst).
 *              WAJIB diverifikasi ulang terhadap dokumentasi/Postman
 *              collection resmi di akun Trustmark BPJS kamu sebelum
 *              dipakai produksi — BPJS bisa merevisi field antar versi
 *              API, dan belum ada kredensial nyata yang dites di
 *              lingkungan pengembangan ini.
 *
 *              $pesertaClient/$sepClient bisa di-inject manual (dipakai
 *              test untuk substitusi fake/mock) — kalau null, dibuat
 *              dari config('services.bpjs_vclaim').
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://github.com/indravscode/bridging-bpjs
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Jkn\Services;

use Bridging\Bpjs\VClaim\Peserta;
use Bridging\Bpjs\VClaim\Sep;
use Modules\Shared\Contracts\IntegrationLoggerInterface;
use Modules\Shared\Contracts\KunjunganStatusInterface;

class VClaimService
{
    private Peserta $pesertaClient;

    private Sep $sepClient;

    public function __construct(
        private readonly IntegrationLoggerInterface $integrationLogger,
        private readonly KunjunganStatusInterface $kunjunganStatus,
        ?Peserta $pesertaClient = null,
        ?Sep $sepClient = null,
    ) {
        $config = config('services.bpjs_vclaim');

        $this->pesertaClient = $pesertaClient ?? new Peserta($config);
        $this->sepClient = $sepClient ?? new Sep($config);
    }

    /** @return array<string, mixed> */
    public function cekEligibilitasPeserta(string $noKartu, string $tanggalSep): array
    {
        $response = $this->pesertaClient->getByNoKartu($noKartu, $tanggalSep);

        $context = [
            'endpoint' => 'Peserta/nokartu',
            'metode' => 'GET',
            'request_payload' => ['no_kartu' => $noKartu, 'tanggal_sep' => $tanggalSep],
            'response_payload' => is_array($response) ? $response : ['raw' => $response],
            'status_code' => (int) ($response['metaData']['code'] ?? 0),
        ];

        if (! is_array($response) || ($response['metaData']['code'] ?? null) !== '200') {
            $pesan = is_array($response) ? ($response['metaData']['message'] ?? 'Gagal cek eligibilitas peserta BPJS.') : 'Gagal menghubungi V-Claim BPJS.';

            $this->integrationLogger->log('bpjs_vclaim', 'error', $pesan, $context);

            abort(502, $pesan);
        }

        $this->integrationLogger->log('bpjs_vclaim', 'info', null, $context);

        return $response['response']['peserta'] ?? [];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array{kunjungan_id: int, no_registrasi: string, no_sep: ?string, status: string}
     */
    public function buatSep(int $kunjunganId, array $data): array
    {
        $kunjungan = $this->kunjunganStatus->detail($kunjunganId);

        abort_if($kunjungan === null, 404, 'Kunjungan tidak ditemukan.');

        $payload = $this->buildSepPayload($data);

        $response = $this->sepClient->insertSEP($payload);

        $context = [
            'referensi_tipe' => 'kunjungan',
            'referensi_id' => $kunjungan['id'],
            'endpoint' => 'SEP/1.1/insert',
            'metode' => 'POST',
            'request_payload' => $payload,
            'response_payload' => is_array($response) ? $response : ['raw' => $response],
            'status_code' => (int) ($response['metaData']['code'] ?? 0),
        ];

        if (! is_array($response) || ($response['metaData']['code'] ?? null) !== '200') {
            $pesan = is_array($response) ? ($response['metaData']['message'] ?? 'Gagal membuat SEP BPJS.') : 'Gagal menghubungi V-Claim BPJS.';

            $this->integrationLogger->log('bpjs_vclaim', 'error', $pesan, $context);

            abort(502, $pesan);
        }

        $this->integrationLogger->log('bpjs_vclaim', 'info', null, $context);

        $noSep = $response['response']['sep']['noSep'] ?? null;

        if ($noSep !== null) {
            $this->kunjunganStatus->updateNoSep($kunjunganId, $noSep);
        }

        return [
            'kunjungan_id' => $kunjungan['id'],
            'no_registrasi' => $kunjungan['no_registrasi'],
            'no_sep' => $noSep,
            'status' => $kunjungan['status'],
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function buildSepPayload(array $data): array
    {
        $tSep = [
            'noKartu' => $data['no_kartu'],
            'tglSep' => $data['tanggal_sep'],
            'ppkPelayanan' => $data['ppk_pelayanan'],
            'jnsPelayanan' => $data['jenis_pelayanan'] === 'rawat_inap' ? '1' : '2',
            'klsRawat' => [
                'klsRawatHak' => $data['kelas_rawat'] ?? '3',
                'klsRawatNaik' => '0',
                'pembiayaan' => '3',
            ],
            'poli' => [
                'tujuan' => $data['poli_tujuan'],
                'eksekutif' => '0',
            ],
            'catatan' => $data['catatan'] ?? '-',
            'diagAwal' => $data['diagnosa_awal'] ?? '',
            'noTelp' => $data['no_telp'] ?? '',
            'user' => $data['user'] ?? 'SIMRS',
        ];

        if (! empty($data['no_rujukan'])) {
            $tSep['rujukan'] = [
                'asalRujukan' => $data['asal_rujukan'] ?? '2',
                'noRujukan' => $data['no_rujukan'],
                'tglRujukan' => $data['tanggal_sep'],
            ];
        }

        return ['request' => ['t_sep' => $tSep]];
    }
}
