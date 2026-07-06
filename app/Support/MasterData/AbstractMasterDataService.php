<?php
/**
 * ============================================================
 * @module      MasterData
 * @layer       Service
 * @file        AbstractMasterDataService.php
 * @path        app/Support/MasterData/AbstractMasterDataService.php
 * @description Business logic generik untuk data master: paginate,
 *              create, update, delete. Setiap modul punya Service
 *              sendiri yang extends class ini dengan constructor
 *              menyempitkan type-hint ke interface repository modulnya
 *              sendiri (lihat app/Modules/Agama/Services/AgamaService.php),
 *              supaya container resolve binding yang benar per modul.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Support\MasterData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class AbstractMasterDataService
{
    public function __construct(
        protected readonly MasterDataRepositoryInterface $repository,
    ) {}

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    /** @param array<string, mixed> $data */
    public function update(int $id, array $data): Model
    {
        $model = $this->repository->findById($id);

        abort_if(! $model, 404, 'Data tidak ditemukan.');

        return $this->repository->update($model, $data);
    }

    public function delete(int $id): void
    {
        $model = $this->repository->findById($id);

        abort_if(! $model, 404, 'Data tidak ditemukan.');

        $this->repository->delete($model);
    }
}
