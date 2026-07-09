<?php
/**
 * ============================================================
 * @module      RawatJalan
 * @layer       Service
 * @file        RawatJalanService.php
 * @path        Modules/RawatJalan/Services/RawatJalanService.php
 * @description Business logic RWJ-01-1: pemeriksaan (SOAP) hanya boleh
 *              dibuat saat kunjungan berstatus 'dipanggil' (pasien
 *              sedang diperiksa), satu kunjungan cuma boleh punya satu
 *              pemeriksaan, dan Assessment wajib punya tepat satu
 *              diagnosis bertipe 'utama'. Status Kunjungan dibaca LIVE
 *              lewat KunjunganStatusInterface (bukan cache) — lihat
 *              catatan lengkap di kontraknya soal kenapa cache tidak
 *              cocok untuk gerbang status seperti ini.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\RawatJalan\Services;

use Modules\RawatJalan\Models\Pemeriksaan;
use Modules\RawatJalan\Repositories\RawatJalanRepository;
use Modules\Shared\Contracts\KunjunganStatusInterface;

final class RawatJalanService
{
    public function __construct(
        private readonly RawatJalanRepository $rawatJalanRepository,
        private readonly KunjunganStatusInterface $kunjunganStatus,
    ) {}

    public function find(int $kunjunganId): Pemeriksaan
    {
        $pemeriksaan = $this->rawatJalanRepository->findByKunjungan($kunjunganId);

        abort_if($pemeriksaan === null, 404, 'Kunjungan ini belum punya pemeriksaan.');

        return $pemeriksaan;
    }

    /** @param array<string, mixed> $data */
    public function createForKunjungan(int $kunjunganId, array $data): Pemeriksaan
    {
        $kunjungan = $this->kunjunganStatus->detail($kunjunganId);

        abort_if($kunjungan === null, 404, 'Kunjungan tidak ditemukan.');
        abort_if($kunjungan['status'] !== 'dipanggil', 422, 'Pemeriksaan hanya bisa dibuat saat kunjungan berstatus dipanggil.');
        abort_if($this->rawatJalanRepository->findByKunjungan($kunjunganId) !== null, 422, 'Kunjungan ini sudah punya pemeriksaan.');

        $this->assertSatuDiagnosisUtama($data['diagnosis'] ?? []);

        return $this->rawatJalanRepository->create($kunjunganId, $data);
    }

    /** @param array<string, mixed> $data */
    public function updateForKunjungan(int $kunjunganId, array $data): Pemeriksaan
    {
        $pemeriksaan = $this->find($kunjunganId);

        if (array_key_exists('diagnosis', $data)) {
            $this->assertSatuDiagnosisUtama($data['diagnosis']);
        }

        return $this->rawatJalanRepository->update($pemeriksaan, $data);
    }

    /** @param array<int, array<string, mixed>> $diagnosis */
    private function assertSatuDiagnosisUtama(array $diagnosis): void
    {
        $jumlahUtama = count(array_filter($diagnosis, fn ($item) => ($item['tipe'] ?? null) === 'utama'));

        abort_if($jumlahUtama !== 1, 422, 'Assessment harus punya tepat satu diagnosis bertipe utama.');
    }
}
