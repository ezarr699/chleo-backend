<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Controller
 * @file        AgamaController.php
 * @path        app/Modules/Agama/Controllers/AgamaController.php
 * @description Handle HTTP request untuk data master Agama (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Agama\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use App\Modules\Agama\Requests\StoreAgamaRequest;
use App\Modules\Agama\Requests\UpdateAgamaRequest;
use App\Modules\Agama\Resources\AgamaResource;
use App\Modules\Agama\Services\AgamaService;

final class AgamaController extends AbstractMasterDataController
{
    public function __construct(
        private readonly AgamaService $agamaService,
    ) {}

    protected function service(): AbstractMasterDataService
    {
        return $this->agamaService;
    }

    protected function resourceClass(): string
    {
        return AgamaResource::class;
    }

    protected function label(): string
    {
        return 'Agama';
    }

    public function store(StoreAgamaRequest $request): JsonResponse
    {
        return $this->handleStore($request->validated());
    }

    public function update(UpdateAgamaRequest $request, int $id): JsonResponse
    {
        return $this->handleUpdate($id, $request->validated());
    }
}
