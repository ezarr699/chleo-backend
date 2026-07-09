<?php
/**
 * ============================================================
 * @module      KategoriLayanan
 * @layer       Controller
 * @file        KategoriLayananController.php
 * @path        Modules/KategoriLayanan/Controllers/KategoriLayananController.php
 * @description Handle HTTP request untuk data master Kategori Layanan (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\KategoriLayanan\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use Modules\KategoriLayanan\Requests\StoreKategoriLayananRequest;
use Modules\KategoriLayanan\Requests\UpdateKategoriLayananRequest;
use Modules\KategoriLayanan\Resources\KategoriLayananResource;
use Modules\KategoriLayanan\Services\KategoriLayananService;

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
