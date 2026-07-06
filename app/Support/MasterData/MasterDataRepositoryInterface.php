<?php
/**
 * ============================================================
 * @module      MasterData
 * @layer       Contract (Interface)
 * @file        MasterDataRepositoryInterface.php
 * @path        app/Support/MasterData/MasterDataRepositoryInterface.php
 * @description Kontrak generik untuk Repository data master (Agama,
 *              Golongan Darah, dst). Setiap modul data master punya
 *              interface sendiri yang extends ini (lihat
 *              app/Modules/Agama/Contracts/AgamaRepositoryInterface.php),
 *              murni untuk binding DI per modul.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Support\MasterData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface MasterDataRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): ?Model;

    /** @param array<string, mixed> $data */
    public function create(array $data): Model;

    /** @param array<string, mixed> $data */
    public function update(Model $model, array $data): Model;

    public function delete(Model $model): bool;
}
