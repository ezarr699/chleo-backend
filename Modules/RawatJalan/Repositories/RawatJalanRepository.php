<?php
/**
 * ============================================================
 * @module      RawatJalan
 * @layer       Repository
 * @file        RawatJalanRepository.php
 * @path        Modules/RawatJalan/Repositories/RawatJalanRepository.php
 * @description Akses data Pemeriksaan + sinkronisasi baris
 *              pemeriksaan_diagnosis (Assessment). Diagnosis selalu
 *              di-replace penuh (delete lalu insert ulang) saat create/
 *              update supaya konsisten dengan payload yang dikirim
 *              client. syncDiagnosis() memanggil Icd10LookupInterface
 *              untuk SNAPSHOT kode+deskripsi ICD-10 ke setiap baris
 *              (Hukum Snapshot Data) — bukan relasi dinamis. create()
 *              memanggil ProfilNakesLookupInterface untuk snapshot nama
 *              nakes yang memeriksa.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\RawatJalan\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\RawatJalan\Models\Pemeriksaan;
use Modules\RawatJalan\Models\PemeriksaanDiagnosis;
use Modules\Shared\Contracts\Icd10LookupInterface;
use Modules\Shared\Contracts\ProfilNakesLookupInterface;

final class RawatJalanRepository
{
    private const RELATIONS = ['diagnosis'];

    public function __construct(
        private readonly Icd10LookupInterface $icd10Lookup,
        private readonly ProfilNakesLookupInterface $profilNakesLookup,
    ) {}

    public function findByKunjungan(int $kunjunganId): ?Pemeriksaan
    {
        return Pemeriksaan::query()
            ->with(self::RELATIONS)
            ->where('kunjungan_id', $kunjunganId)
            ->first();
    }

    /** @param array<string, mixed> $data */
    public function create(int $kunjunganId, array $data): Pemeriksaan
    {
        return DB::transaction(function () use ($kunjunganId, $data) {
            $diagnosis = $data['diagnosis'] ?? [];
            unset($data['diagnosis']);

            $pemeriksaan = Pemeriksaan::create([
                ...$data,
                'kunjungan_id' => $kunjunganId,
                'nama_nakes_snapshot' => $this->profilNakesLookup->namaLengkap((int) $data['profil_nakes_id']),
                'diperiksa_pada' => $data['diperiksa_pada'] ?? now(),
            ]);

            $this->syncDiagnosis($pemeriksaan, $diagnosis);

            return $pemeriksaan->load(self::RELATIONS);
        });
    }

    /** @param array<string, mixed> $data */
    public function update(Pemeriksaan $pemeriksaan, array $data): Pemeriksaan
    {
        return DB::transaction(function () use ($pemeriksaan, $data) {
            $diagnosis = $data['diagnosis'] ?? null;
            unset($data['diagnosis']);

            if (array_key_exists('profil_nakes_id', $data)) {
                $data['nama_nakes_snapshot'] = $this->profilNakesLookup->namaLengkap((int) $data['profil_nakes_id']);
            }

            $pemeriksaan->update($data);

            if ($diagnosis !== null) {
                $pemeriksaan->diagnosis()->delete();
                $this->syncDiagnosis($pemeriksaan, $diagnosis);
            }

            return $pemeriksaan->fresh(self::RELATIONS);
        });
    }

    /** @param array<int, array<string, mixed>> $diagnosis */
    private function syncDiagnosis(Pemeriksaan $pemeriksaan, array $diagnosis): void
    {
        foreach ($diagnosis as $item) {
            $detail = $this->icd10Lookup->detail((int) $item['icd10_id']);

            PemeriksaanDiagnosis::create([
                'pemeriksaan_id' => $pemeriksaan->id,
                'icd10_id' => $item['icd10_id'],
                'icd10_kode_snapshot' => $detail['kode'] ?? null,
                'icd10_deskripsi_snapshot' => $detail['deskripsi'] ?? null,
                'tipe' => $item['tipe'] ?? 'sekunder',
                'catatan' => $item['catatan'] ?? null,
            ]);
        }
    }
}
