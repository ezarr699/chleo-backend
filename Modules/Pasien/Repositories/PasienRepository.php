<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Repository
 * @file        PasienRepository.php
 * @path        Modules/Pasien/Repositories/PasienRepository.php
 * @description Akses data Pasien. Tidak extend AbstractMasterDataRepository
 *              karena Pasien punya method tambahan (verify, setStatus) yang
 *              tidak ada di kontrak data master generik. Eager-load hanya
 *              asuransiList (relasi milik modul sendiri) — jenisKelamin/
 *              golonganDarah/provinsi/kabupaten/kecamatan/kelurahan dulu
 *              di-eager-load di sini juga, tapi relasinya sudah dihapus
 *              dari Model (Hukum Isolasi Total Eloquent); resolusi nama
 *              sekarang tanggung jawab PasienService lewat cache lokal +
 *              WilayahLookupInterface.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pasien\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Pasien\Models\Pasien;

final class PasienRepository
{
    /** @return LengthAwarePaginator<int, Pasien> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Pasien::query()
            ->with(['asuransiList'])
            ->latest('created_at')
            ->paginate($perPage);
    }

    public function findById(int $id): ?Pasien
    {
        return Pasien::query()->with(['asuransiList'])->find($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Pasien
    {
        return Pasien::create(['status' => 'belum_verifikasi', ...$data]);
    }

    /** @param array<string, mixed> $data */
    public function update(Pasien $pasien, array $data): Pasien
    {
        $pasien->update($data);

        return $pasien->load(['asuransiList']);
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<int, array{asuransi_id: int, nomor_polis?: string, masa_berlaku?: string}>  $asuransiEntries
     */
    public function verify(Pasien $pasien, array $data, array $asuransiEntries = []): Pasien
    {
        $pasien->update([
            ...$data,
            'status' => 'aktif',
            'verified_at' => now(),
        ]);

        $pasien->asuransiList()->delete();
        $pasien->asuransiList()->createMany($asuransiEntries);

        return $pasien->load(['asuransiList']);
    }

    public function setStatus(Pasien $pasien, bool $aktif): Pasien
    {
        $pasien->update(['status' => $aktif ? 'aktif' : 'nonaktif']);

        return $pasien;
    }

    public function delete(Pasien $pasien): void
    {
        $pasien->delete();
    }
}
