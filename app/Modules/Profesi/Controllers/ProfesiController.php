<?php
/**
 * ============================================================
 * @module      Profesi
 * @layer       Controller
 * @file        ProfesiController.php
 * @path        app/Modules/Profesi/Controllers/ProfesiController.php
 * @description Handle HTTP request untuk data master Profesi (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Profesi\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use App\Modules\Profesi\Requests\StoreProfesiRequest;
use App\Modules\Profesi\Requests\UpdateProfesiRequest;
use App\Modules\Profesi\Resources\ProfesiResource;
use App\Modules\Profesi\Services\ProfesiService;

final class ProfesiController extends AbstractMasterDataController
{
    public function __construct(
        private readonly ProfesiService $profesiService,
    ) {}

    protected function service(): AbstractMasterDataService
    {
        return $this->profesiService;
    }

    protected function resourceClass(): string
    {
        return ProfesiResource::class;
    }

    protected function label(): string
    {
        return 'Profesi';
    }

    public function store(StoreProfesiRequest $request): JsonResponse
    {
        return $this->handleStore($request->validated());
    }

    public function update(UpdateProfesiRequest $request, int $id): JsonResponse
    {
        return $this->handleUpdate($id, $request->validated());
    }
}
