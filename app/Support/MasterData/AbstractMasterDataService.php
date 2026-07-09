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
 *              menyempitkan type-hint ke Repository modulnya sendiri
 *              (lihat Modules/Agama/Services/AgamaService.php), supaya
 *              container resolve binding yang benar per modul.
 *              create()/update() men-dispatch MasterDataCreatedOrUpdated
 *              supaya modul lain yang butuh data master ini (mis.
 *              Pasien butuh JenisKelamin/GolonganDarah/Asuransi) bisa
 *              menyinkronkan cache lokalnya sendiri tanpa modul data
 *              master ini perlu tahu siapa saja subscriber-nya — lihat
 *              app/Events/MasterDataCreatedOrUpdated.php. Dispatch
 *              berlaku otomatis untuk SEMUA modul data master, dipakai
 *              atau tidak subscriber-nya — event tanpa listener praktis
 *              tanpa biaya di Laravel.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Support\MasterData;

use App\Events\MasterDataCreatedOrUpdated;
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
        $model = $this->repository->create($data);

        event(MasterDataCreatedOrUpdated::fromModel($model));

        return $model;
    }

    /** @param array<string, mixed> $data */
    public function update(int $id, array $data): Model
    {
        $model = $this->repository->findById($id);

        abort_if(! $model, 404, 'Data tidak ditemukan.');

        $model = $this->repository->update($model, $data);

        event(MasterDataCreatedOrUpdated::fromModel($model));

        return $model;
    }

    public function delete(int $id): void
    {
        $model = $this->repository->findById($id);

        abort_if(! $model, 404, 'Data tidak ditemukan.');

        $this->repository->delete($model);
    }
}
