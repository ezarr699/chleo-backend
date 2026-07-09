<?php
/**
 * ============================================================
 * @module      StatusPerkawinan
 * @layer       Controller
 * @file        StatusPerkawinanController.php
 * @path        Modules/StatusPerkawinan/Controllers/StatusPerkawinanController.php
 * @description Handle HTTP request untuk data master Status Perkawinan (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\StatusPerkawinan\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use Modules\StatusPerkawinan\Requests\StoreStatusPerkawinanRequest;
use Modules\StatusPerkawinan\Requests\UpdateStatusPerkawinanRequest;
use Modules\StatusPerkawinan\Resources\StatusPerkawinanResource;
use Modules\StatusPerkawinan\Services\StatusPerkawinanService;

final class StatusPerkawinanController extends AbstractMasterDataController
{
    public function __construct(
        private readonly StatusPerkawinanService $statusPerkawinanService,
    ) {}

    protected function service(): AbstractMasterDataService
    {
        return $this->statusPerkawinanService;
    }

    protected function resourceClass(): string
    {
        return StatusPerkawinanResource::class;
    }

    protected function label(): string
    {
        return 'Status Perkawinan';
    }

    public function store(StoreStatusPerkawinanRequest $request): JsonResponse
    {
        return $this->handleStore($request->validated());
    }

    public function update(UpdateStatusPerkawinanRequest $request, int $id): JsonResponse
    {
        return $this->handleUpdate($id, $request->validated());
    }
}
