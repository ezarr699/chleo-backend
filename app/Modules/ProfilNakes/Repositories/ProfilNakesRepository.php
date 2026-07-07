<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Repository
 * @file        ProfilNakesRepository.php
 * @path        app/Modules/ProfilNakes/Repositories/ProfilNakesRepository.php
 * @description Akses data ProfilNakes. Tidak extend AbstractMasterDataRepository
 *              karena ProfilNakes punya relasi (user, profesi, poliklinik),
 *              bukan data master nama-doang.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\ProfilNakes\Repositories;

use App\Models\ProfilNakes;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Modules\ProfilNakes\Contracts\ProfilNakesRepositoryInterface;

final class ProfilNakesRepository implements ProfilNakesRepositoryInterface
{
    private const RELATIONS = ['user:id,name,email', 'profesi', 'poliklinik'];

    /** @return LengthAwarePaginator<int, ProfilNakes> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return ProfilNakes::query()
            ->with(self::RELATIONS)
            ->latest('created_at')
            ->paginate($perPage);
    }

    public function findById(int $id): ?ProfilNakes
    {
        return ProfilNakes::query()->with(self::RELATIONS)->find($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): ProfilNakes
    {
        return ProfilNakes::create($data)->load(self::RELATIONS);
    }

    /** @param array<string, mixed> $data */
    public function update(ProfilNakes $profilNakes, array $data): ProfilNakes
    {
        $profilNakes->update($data);

        return $profilNakes->load(self::RELATIONS);
    }

    public function delete(ProfilNakes $profilNakes): bool
    {
        return $profilNakes->delete();
    }
}
