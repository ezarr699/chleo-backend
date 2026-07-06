<?php
/**
 * ============================================================
 * @module      JenisKelamin
 * @layer       Controller
 * @file        JenisKelaminController.php
 * @path        app/Modules/JenisKelamin/Controllers/JenisKelaminController.php
 * @description Handle HTTP request untuk data master Jenis Kelamin (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\JenisKelamin\Controllers;

use App\Support\MasterData\AbstractMasterDataController;
use App\Support\MasterData\AbstractMasterDataService;
use Illuminate\Http\JsonResponse;
use App\Modules\JenisKelamin\Requests\StoreJenisKelaminRequest;
use App\Modules\JenisKelamin\Requests\UpdateJenisKelaminRequest;
use App\Modules\JenisKelamin\Resources\JenisKelaminResource;
use App\Modules\JenisKelamin\Services\JenisKelaminService;

final class JenisKelaminController extends AbstractMasterDataController
{
    public function __construct(
        private readonly JenisKelaminService $jenisKelaminService,
    ) {}

    protected function service(): AbstractMasterDataService
    {
        return $this->jenisKelaminService;
    }

    protected function resourceClass(): string
    {
        return JenisKelaminResource::class;
    }

    protected function label(): string
    {
        return 'Jenis Kelamin';
    }

    public function store(StoreJenisKelaminRequest $request): JsonResponse
    {
        return $this->handleStore($request->validated());
    }

    public function update(UpdateJenisKelaminRequest $request, int $id): JsonResponse
    {
        return $this->handleUpdate($id, $request->validated());
    }
}
