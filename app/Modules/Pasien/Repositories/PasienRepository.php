<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Repository
 * @file        PasienRepository.php
 * @path        app/Modules/Pasien/Repositories/PasienRepository.php
 * @description Akses data Pasien. Tidak extend AbstractMasterDataRepository
 *              karena Pasien punya method tambahan (verify, setStatus) yang
 *              tidak ada di kontrak data master generik.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Pasien\Repositories;

use App\Models\Pasien;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Modules\Pasien\Contracts\PasienRepositoryInterface;

final class PasienRepository implements PasienRepositoryInterface
{
    /** @return LengthAwarePaginator<int, Pasien> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Pasien::query()
            ->with(['jenisKelamin', 'golonganDarah', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'asuransiList.asuransi'])
            ->latest('created_at')
            ->paginate($perPage);
    }

    public function findById(int $id): ?Pasien
    {
        return Pasien::query()->with(['jenisKelamin', 'golonganDarah', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'asuransiList.asuransi'])->find($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Pasien
    {
        return Pasien::create(['status' => 'belum_verifikasi', ...$data])->load(['jenisKelamin']);
    }

    /** @param array<string, mixed> $data */
    public function update(Pasien $pasien, array $data): Pasien
    {
        $pasien->update($data);

        return $pasien->load(['jenisKelamin', 'golonganDarah', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'asuransiList.asuransi']);
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

        return $pasien->load(['jenisKelamin', 'golonganDarah', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'asuransiList.asuransi']);
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
