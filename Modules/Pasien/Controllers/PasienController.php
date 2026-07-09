<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Controller
 * @file        PasienController.php
 * @path        Modules/Pasien/Controllers/PasienController.php
 * @description Handle HTTP request untuk resource Pasien: CRUD dasar,
 *              verifikasi (upload foto + lengkapi data), dan toggle
 *              status aktif/nonaktif.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pasien\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Pasien\Requests\SetPasienStatusRequest;
use Modules\Pasien\Requests\StorePasienRequest;
use Modules\Pasien\Requests\UpdatePasienRequest;
use Modules\Pasien\Requests\VerifyPasienRequest;
use Modules\Pasien\Resources\PasienResource;
use Modules\Pasien\Services\PasienService;

final class PasienController extends Controller
{
    public function __construct(
        private readonly PasienService $pasienService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->integer('per_page', 15);
        $paginated = $this->pasienService->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Daftar pasien berhasil diambil.',
            'data' => PasienResource::collection($paginated->getCollection()),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ],
        ]);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail pasien berhasil diambil.',
            'data' => new PasienResource($this->pasienService->find($id)),
        ]);
    }

    public function store(StorePasienRequest $request): JsonResponse
    {
        $pasien = $this->pasienService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Pasien berhasil ditambahkan.',
            'data' => new PasienResource($pasien),
        ], 201);
    }

    public function update(UpdatePasienRequest $request, int $id): JsonResponse
    {
        $pasien = $this->pasienService->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Pasien berhasil diperbarui.',
            'data' => new PasienResource($pasien),
        ]);
    }

    public function verify(VerifyPasienRequest $request, int $id): JsonResponse
    {
        $validated = $request->validated();
        unset($validated['foto']);
        $asuransiEntries = $validated['asuransi'] ?? [];
        unset($validated['asuransi']);

        $pasien = $this->pasienService->verify($id, $validated, $request->file('foto'), $asuransiEntries);

        return response()->json([
            'success' => true,
            'message' => 'Pasien berhasil diverifikasi.',
            'data' => new PasienResource($pasien),
        ]);
    }

    public function setStatus(SetPasienStatusRequest $request, int $id): JsonResponse
    {
        $pasien = $this->pasienService->setStatus($id, $request->boolean('aktif'));

        return response()->json([
            'success' => true,
            'message' => $pasien->status === 'aktif'
                ? 'Pasien berhasil diaktifkan.'
                : 'Pasien berhasil dinonaktifkan.',
            'data' => new PasienResource($pasien),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->pasienService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Pasien berhasil dihapus.',
            'data' => null,
        ]);
    }
}
