<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Controller
 * @file        PekerjaanController.php
 * @path        Modules/Pekerjaan/Controllers/PekerjaanController.php
 * @description Handle HTTP request untuk data master Pekerjaan (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pekerjaan\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use Modules\Pekerjaan\Requests\StorePekerjaanRequest;
use Modules\Pekerjaan\Requests\UpdatePekerjaanRequest;
use Modules\Pekerjaan\Resources\PekerjaanResource;
use Modules\Pekerjaan\Services\PekerjaanService;

final class PekerjaanController extends AbstractMasterDataController
{
    public function __construct(
        private readonly PekerjaanService $pekerjaanService,
    ) {}

    protected function service(): AbstractMasterDataService
    {
        return $this->pekerjaanService;
    }

    protected function resourceClass(): string
    {
        return PekerjaanResource::class;
    }

    protected function label(): string
    {
        return 'Pekerjaan';
    }

    public function store(StorePekerjaanRequest $request): JsonResponse
    {
        return $this->handleStore($request->validated());
    }

    public function update(UpdatePekerjaanRequest $request, int $id): JsonResponse
    {
        return $this->handleUpdate($id, $request->validated());
    }
}
