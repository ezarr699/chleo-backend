<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Controller
 * @file        SatuanController.php
 * @path        Modules/Satuan/Controllers/SatuanController.php
 * @description Handle HTTP request untuk data master Satuan (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Satuan\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use Modules\Satuan\Requests\StoreSatuanRequest;
use Modules\Satuan\Requests\UpdateSatuanRequest;
use Modules\Satuan\Resources\SatuanResource;
use Modules\Satuan\Services\SatuanService;

final class SatuanController extends AbstractMasterDataController
{
    public function __construct(
        private readonly SatuanService $satuanService,
    ) {}

    protected function service(): AbstractMasterDataService
    {
        return $this->satuanService;
    }

    protected function resourceClass(): string
    {
        return SatuanResource::class;
    }

    protected function label(): string
    {
        return 'Satuan';
    }

    public function store(StoreSatuanRequest $request): JsonResponse
    {
        return $this->handleStore($request->validated());
    }

    public function update(UpdateSatuanRequest $request, int $id): JsonResponse
    {
        return $this->handleUpdate($id, $request->validated());
    }
}
