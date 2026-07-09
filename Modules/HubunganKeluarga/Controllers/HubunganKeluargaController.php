<?php
/**
 * ============================================================
 * @module      HubunganKeluarga
 * @layer       Controller
 * @file        HubunganKeluargaController.php
 * @path        Modules/HubunganKeluarga/Controllers/HubunganKeluargaController.php
 * @description Handle HTTP request untuk data master Hubungan Keluarga (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\HubunganKeluarga\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use Modules\HubunganKeluarga\Requests\StoreHubunganKeluargaRequest;
use Modules\HubunganKeluarga\Requests\UpdateHubunganKeluargaRequest;
use Modules\HubunganKeluarga\Resources\HubunganKeluargaResource;
use Modules\HubunganKeluarga\Services\HubunganKeluargaService;

final class HubunganKeluargaController extends AbstractMasterDataController
{
    public function __construct(
        private readonly HubunganKeluargaService $hubunganKeluargaService,
    ) {}

    protected function service(): AbstractMasterDataService
    {
        return $this->hubunganKeluargaService;
    }

    protected function resourceClass(): string
    {
        return HubunganKeluargaResource::class;
    }

    protected function label(): string
    {
        return 'Hubungan Keluarga';
    }

    public function store(StoreHubunganKeluargaRequest $request): JsonResponse
    {
        return $this->handleStore($request->validated());
    }

    public function update(UpdateHubunganKeluargaRequest $request, int $id): JsonResponse
    {
        return $this->handleUpdate($id, $request->validated());
    }
}
