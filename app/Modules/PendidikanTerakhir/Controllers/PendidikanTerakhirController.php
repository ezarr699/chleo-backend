<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Controller
 * @file        PendidikanTerakhirController.php
 * @path        app/Modules/PendidikanTerakhir/Controllers/PendidikanTerakhirController.php
 * @description Handle HTTP request untuk data master Pendidikan Terakhir (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\PendidikanTerakhir\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use App\Modules\PendidikanTerakhir\Requests\StorePendidikanTerakhirRequest;
use App\Modules\PendidikanTerakhir\Requests\UpdatePendidikanTerakhirRequest;
use App\Modules\PendidikanTerakhir\Resources\PendidikanTerakhirResource;
use App\Modules\PendidikanTerakhir\Services\PendidikanTerakhirService;

final class PendidikanTerakhirController extends AbstractMasterDataController
{
    public function __construct(
        private readonly PendidikanTerakhirService $pendidikanTerakhirService,
    ) {}

    protected function service(): AbstractMasterDataService
    {
        return $this->pendidikanTerakhirService;
    }

    protected function resourceClass(): string
    {
        return PendidikanTerakhirResource::class;
    }

    protected function label(): string
    {
        return 'Pendidikan Terakhir';
    }

    public function store(StorePendidikanTerakhirRequest $request): JsonResponse
    {
        return $this->handleStore($request->validated());
    }

    public function update(UpdatePendidikanTerakhirRequest $request, int $id): JsonResponse
    {
        return $this->handleUpdate($id, $request->validated());
    }
}
