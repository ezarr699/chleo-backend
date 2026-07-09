<?php
/**
 * ============================================================
 * @module      RawatJalan
 * @layer       Controller
 * @file        RawatJalanController.php
 * @path        Modules/RawatJalan/Controllers/RawatJalanController.php
 * @description Handle HTTP request untuk pemeriksaan rawat jalan (SOAP,
 *              RWJ-01-1) yang menempel ke satu Kunjungan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\RawatJalan\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\RawatJalan\Requests\StorePemeriksaanRequest;
use Modules\RawatJalan\Requests\UpdatePemeriksaanRequest;
use Modules\RawatJalan\Resources\PemeriksaanResource;
use Modules\RawatJalan\Services\RawatJalanService;

final class RawatJalanController extends Controller
{
    public function __construct(
        private readonly RawatJalanService $rawatJalanService,
    ) {}

    public function show(int $kunjunganId): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Pemeriksaan berhasil diambil.',
            'data' => new PemeriksaanResource($this->rawatJalanService->find($kunjunganId)),
        ]);
    }

    public function store(StorePemeriksaanRequest $request, int $kunjunganId): JsonResponse
    {
        $pemeriksaan = $this->rawatJalanService->createForKunjungan($kunjunganId, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Pemeriksaan berhasil disimpan.',
            'data' => new PemeriksaanResource($pemeriksaan),
        ], 201);
    }

    public function update(UpdatePemeriksaanRequest $request, int $kunjunganId): JsonResponse
    {
        $pemeriksaan = $this->rawatJalanService->updateForKunjungan($kunjunganId, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Pemeriksaan berhasil diperbarui.',
            'data' => new PemeriksaanResource($pemeriksaan),
        ]);
    }
}
