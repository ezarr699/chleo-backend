<?php
/**
 * ============================================================
 * @module      GolonganDarah
 * @layer       Controller
 * @file        GolonganDarahController.php
 * @path        app/Modules/GolonganDarah/Controllers/GolonganDarahController.php
 * @description Handle HTTP request untuk data master Golongan Darah (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\GolonganDarah\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use App\Modules\GolonganDarah\Requests\StoreGolonganDarahRequest;
use App\Modules\GolonganDarah\Requests\UpdateGolonganDarahRequest;
use App\Modules\GolonganDarah\Resources\GolonganDarahResource;
use App\Modules\GolonganDarah\Services\GolonganDarahService;

final class GolonganDarahController extends AbstractMasterDataController
{
    public function __construct(
        private readonly GolonganDarahService $golonganDarahService,
    ) {}

    protected function service(): AbstractMasterDataService
    {
        return $this->golonganDarahService;
    }

    protected function resourceClass(): string
    {
        return GolonganDarahResource::class;
    }

    protected function label(): string
    {
        return 'Golongan Darah';
    }

    public function store(StoreGolonganDarahRequest $request): JsonResponse
    {
        return $this->handleStore($request->validated());
    }

    public function update(UpdateGolonganDarahRequest $request, int $id): JsonResponse
    {
        return $this->handleUpdate($id, $request->validated());
    }
}
