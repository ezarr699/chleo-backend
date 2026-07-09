<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Repository
 * @file        ProfilNakesRepository.php
 * @path        Modules/ProfilNakes/Repositories/ProfilNakesRepository.php
 * @description Akses data ProfilNakes. Tidak extend AbstractMasterDataRepository
 *              karena ProfilNakes punya field tambahan (user_id, profesi_id,
 *              poliklinik_id), bukan data master nama-doang. Eager-load
 *              relasi (user/profesi/poliklinik) dihapus — sudah bukan
 *              relasi Eloquent lagi (Hukum Isolasi Total Eloquent); nama
 *              tampilan diresolusi ProfilNakesService lewat cache lokal.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\ProfilNakes\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\ProfilNakes\Models\ProfilNakes;

final class ProfilNakesRepository
{
    /** @return LengthAwarePaginator<int, ProfilNakes> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return ProfilNakes::query()
            ->latest('created_at')
            ->paginate($perPage);
    }

    public function findById(int $id): ?ProfilNakes
    {
        return ProfilNakes::query()->find($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): ProfilNakes
    {
        return ProfilNakes::create($data);
    }

    /** @param array<string, mixed> $data */
    public function update(ProfilNakes $profilNakes, array $data): ProfilNakes
    {
        $profilNakes->update($data);

        return $profilNakes;
    }

    public function delete(ProfilNakes $profilNakes): bool
    {
        return $profilNakes->delete();
    }
}
