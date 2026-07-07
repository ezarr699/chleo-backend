<?php
/**
 * ============================================================
 * @module      KategoriTriase
 * @layer       Controller
 * @file        KategoriTriaseController.php
 * @path        app/Modules/KategoriTriase/Controllers/KategoriTriaseController.php
 * @description Handle HTTP request untuk data master Kategori Triase (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\KategoriTriase\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use App\Modules\KategoriTriase\Requests\StoreKategoriTriaseRequest;
use App\Modules\KategoriTriase\Requests\UpdateKategoriTriaseRequest;
use App\Modules\KategoriTriase\Resources\KategoriTriaseResource;
use App\Modules\KategoriTriase\Services\KategoriTriaseService;

final class KategoriTriaseController extends AbstractMasterDataController
{
    public function __construct(
        private readonly KategoriTriaseService $kategoriTriaseService,
    ) {}

    protected function service(): AbstractMasterDataService
    {
        return $this->kategoriTriaseService;
    }

    protected function resourceClass(): string
    {
        return KategoriTriaseResource::class;
    }

    protected function label(): string
    {
        return 'Kategori Triase';
    }

    public function store(StoreKategoriTriaseRequest $request): JsonResponse
    {
        return $this->handleStore($request->validated());
    }

    public function update(UpdateKategoriTriaseRequest $request, int $id): JsonResponse
    {
        return $this->handleUpdate($id, $request->validated());
    }
}
