<?php
/**
 * ============================================================
 * @module      KategoriObat
 * @layer       Controller
 * @file        KategoriObatController.php
 * @path        Modules/KategoriObat/Controllers/KategoriObatController.php
 * @description Handle HTTP request untuk data master Kategori Obat (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\KategoriObat\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use Modules\KategoriObat\Requests\StoreKategoriObatRequest;
use Modules\KategoriObat\Requests\UpdateKategoriObatRequest;
use Modules\KategoriObat\Resources\KategoriObatResource;
use Modules\KategoriObat\Services\KategoriObatService;

final class KategoriObatController extends AbstractMasterDataController
{
    public function __construct(
        private readonly KategoriObatService $kategoriObatService,
    ) {}

    protected function service(): AbstractMasterDataService
    {
        return $this->kategoriObatService;
    }

    protected function resourceClass(): string
    {
        return KategoriObatResource::class;
    }

    protected function label(): string
    {
        return 'Kategori Obat';
    }

    public function store(StoreKategoriObatRequest $request): JsonResponse
    {
        return $this->handleStore($request->validated());
    }

    public function update(UpdateKategoriObatRequest $request, int $id): JsonResponse
    {
        return $this->handleUpdate($id, $request->validated());
    }
}
