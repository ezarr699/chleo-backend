<?php
/**
 * ============================================================
 * @module      Jkn
 * @layer       Controller
 * @file        VClaimController.php
 * @path        Modules/Jkn/Controllers/VClaimController.php
 * @description Handle HTTP request bridging V-Claim BPJS (JKN-01-2):
 *              cek eligibilitas peserta & buat SEP untuk kunjungan yang
 *              sudah terdaftar. buatSep() mengembalikan array polos
 *              (bukan Model Kunjungan) dari VClaimService — lihat
 *              catatan di sana — jadi dikirim langsung sebagai 'data'
 *              tanpa Resource (tidak ada Model untuk dibungkus).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Jkn\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Jkn\Requests\CekEligibilitasRequest;
use Modules\Jkn\Requests\StoreSepRequest;
use Modules\Jkn\Services\VClaimService;

final class VClaimController extends Controller
{
    public function __construct(
        private readonly VClaimService $vClaimService,
    ) {}

    public function eligibilitas(CekEligibilitasRequest $request): JsonResponse
    {
        $data = $request->validated();
        $peserta = $this->vClaimService->cekEligibilitasPeserta($data['no_kartu'], $data['tanggal_sep']);

        return response()->json([
            'success' => true,
            'message' => 'Eligibilitas peserta BPJS berhasil dicek.',
            'data' => $peserta,
        ]);
    }

    public function buatSep(StoreSepRequest $request, int $id): JsonResponse
    {
        $sep = $this->vClaimService->buatSep($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'SEP BPJS berhasil dibuat.',
            'data' => $sep,
        ], 201);
    }
}
