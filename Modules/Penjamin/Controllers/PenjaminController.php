<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Controller
 * @file        PenjaminController.php
 * @path        Modules/Penjamin/Controllers/PenjaminController.php
 * @description Handle HTTP request untuk data master Penjamin (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Penjamin\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use Modules\Penjamin\Requests\StorePenjaminRequest;
use Modules\Penjamin\Requests\UpdatePenjaminRequest;
use Modules\Penjamin\Resources\PenjaminResource;
use Modules\Penjamin\Services\PenjaminService;

final class PenjaminController extends AbstractMasterDataController
{
    public function __construct(
        private readonly PenjaminService $penjaminService,
    ) {}

    protected function service(): AbstractMasterDataService
    {
        return $this->penjaminService;
    }

    protected function resourceClass(): string
    {
        return PenjaminResource::class;
    }

    protected function label(): string
    {
        return 'Penjamin';
    }

    public function store(StorePenjaminRequest $request): JsonResponse
    {
        return $this->handleStore($request->validated());
    }

    public function update(UpdatePenjaminRequest $request, int $id): JsonResponse
    {
        return $this->handleUpdate($id, $request->validated());
    }
}
