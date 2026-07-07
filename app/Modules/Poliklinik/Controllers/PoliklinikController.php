<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Controller
 * @file        PoliklinikController.php
 * @path        app/Modules/Poliklinik/Controllers/PoliklinikController.php
 * @description Handle HTTP request untuk data master Poliklinik (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Poliklinik\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use App\Modules\Poliklinik\Requests\StorePoliklinikRequest;
use App\Modules\Poliklinik\Requests\UpdatePoliklinikRequest;
use App\Modules\Poliklinik\Resources\PoliklinikResource;
use App\Modules\Poliklinik\Services\PoliklinikService;

final class PoliklinikController extends AbstractMasterDataController
{
    public function __construct(
        private readonly PoliklinikService $poliklinikService,
    ) {}

    protected function service(): AbstractMasterDataService
    {
        return $this->poliklinikService;
    }

    protected function resourceClass(): string
    {
        return PoliklinikResource::class;
    }

    protected function label(): string
    {
        return 'Poliklinik';
    }

    public function store(StorePoliklinikRequest $request): JsonResponse
    {
        return $this->handleStore($request->validated());
    }

    public function update(UpdatePoliklinikRequest $request, int $id): JsonResponse
    {
        return $this->handleUpdate($id, $request->validated());
    }
}
