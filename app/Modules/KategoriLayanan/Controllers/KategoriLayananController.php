<?php
/**
 * ============================================================
 * @module      KategoriLayanan
 * @layer       Controller
 * @file        KategoriLayananController.php
 * @path        app/Modules/KategoriLayanan/Controllers/KategoriLayananController.php
 * @description Handle HTTP request untuk data master Kategori Layanan (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\KategoriLayanan\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use App\Modules\KategoriLayanan\Requests\StoreKategoriLayananRequest;
use App\Modules\KategoriLayanan\Requests\UpdateKategoriLayananRequest;
use App\Modules\KategoriLayanan\Resources\KategoriLayananResource;
use App\Modules\KategoriLayanan\Services\KategoriLayananService;

final class KategoriLayananController extends AbstractMasterDataController
{
    public function __construct(
        private readonly KategoriLayananService $kategoriLayananService,
    ) {}

    protected function service(): AbstractMasterDataService
    {
        return $this->kategoriLayananService;
    }

    protected function resourceClass(): string
    {
        return KategoriLayananResource::class;
    }

    protected function label(): string
    {
        return 'Kategori Layanan';
    }

    public function store(StoreKategoriLayananRequest $request): JsonResponse
    {
        return $this->handleStore($request->validated());
    }

    public function update(UpdateKategoriLayananRequest $request, int $id): JsonResponse
    {
        return $this->handleUpdate($id, $request->validated());
    }
}
