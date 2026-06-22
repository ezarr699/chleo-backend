<?php
/**
 * ============================================================
 * @module      MasterData
 * @layer       Repository
 * @file        AbstractMasterDataRepository.php
 * @path        app/Support/MasterData/AbstractMasterDataRepository.php
 * @description Implementasi CRUD generik untuk data master. Setiap modul
 *              (Agama, GolonganDarah, dst) hanya perlu extends class ini
 *              dan mengisi modelClass(). Soft delete otomatis berlaku
 *              karena model-nya pakai trait SoftDeletes — paginate()/
 *              findById() otomatis exclude trashed lewat global scope
 *              Eloquent bawaan, tidak perlu kode tambahan di sini.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Support\MasterData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class AbstractMasterDataRepository implements MasterDataRepositoryInterface
{
    /** @return class-string<Model> */
    abstract protected function modelClass(): string;

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->modelClass()::query()->orderBy('name')->paginate($perPage);
    }

    public function findById(int $id): ?Model
    {
        return $this->modelClass()::query()->find($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Model
    {
        return $this->modelClass()::query()->create($data);
    }

    /** @param array<string, mixed> $data */
    public function update(Model $model, array $data): Model
    {
        $model->update($data);

        return $model;
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }
}
