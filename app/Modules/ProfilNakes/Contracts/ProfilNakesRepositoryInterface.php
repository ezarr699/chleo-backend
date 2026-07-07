<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Contract (Interface)
 * @file        ProfilNakesRepositoryInterface.php
 * @path        app/Modules/ProfilNakes/Contracts/ProfilNakesRepositoryInterface.php
 * @description Kontrak Repository ProfilNakes. Bukan turunan
 *              MasterDataRepositoryInterface karena ProfilNakes punya
 *              relasi (user, profesi, poliklinik), bukan data master
 *              nama-doang.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\ProfilNakes\Contracts;

use App\Models\ProfilNakes;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProfilNakesRepositoryInterface
{
    /** @return LengthAwarePaginator<int, ProfilNakes> */
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): ?ProfilNakes;

    /** @param array<string, mixed> $data */
    public function create(array $data): ProfilNakes;

    /** @param array<string, mixed> $data */
    public function update(ProfilNakes $profilNakes, array $data): ProfilNakes;

    public function delete(ProfilNakes $profilNakes): bool;
}
