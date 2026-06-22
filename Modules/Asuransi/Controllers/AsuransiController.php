<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Controller
 * @file        AsuransiController.php
 * @path        Modules/Asuransi/Controllers/AsuransiController.php
 * @description Handle HTTP request untuk data master Asuransi (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Asuransi\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use Modules\Asuransi\Requests\StoreAsuransiRequest;
use Modules\Asuransi\Requests\UpdateAsuransiRequest;
use Modules\Asuransi\Resources\AsuransiResource;
use Modules\Asuransi\Services\AsuransiService;

final class AsuransiController extends AbstractMasterDataController
{
    public function __construct(
        private readonly AsuransiService $asuransiService,
    ) {}

    protected function service(): AbstractMasterDataService
    {
        return $this->asuransiService;
    }

    protected function resourceClass(): string
    {
        return AsuransiResource::class;
    }

    protected function label(): string
    {
        return 'Asuransi';
    }

    public function store(StoreAsuransiRequest $request): JsonResponse
    {
        return $this->handleStore($request->validated());
    }

    public function update(UpdateAsuransiRequest $request, int $id): JsonResponse
    {
        return $this->handleUpdate($id, $request->validated());
    }
}
