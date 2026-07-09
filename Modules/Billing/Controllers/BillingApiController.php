<?php
/**
 * ============================================================
 * @module      Billing
 * @layer       Controller
 * @file        BillingApiController.php
 * @path        Modules/Billing/Controllers/BillingApiController.php
 * @description Skinny controller untuk resource Invoice. Hanya menerima
 *              request, menjalankan validasi HTTP formal, mengunci tipe
 *              data lewat CreateInvoiceDTO, lalu mendelegasikan ke
 *              BillingService. Tidak ada business logic maupun query
 *              database di sini (Hukum Jalur Tunggal).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://laravel.com/docs/13.x/controllers
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Billing\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Billing\DTOs\CreateInvoiceDTO;
use Modules\Billing\Resources\InvoiceResource;
use Modules\Billing\Services\BillingService;

final class BillingApiController extends Controller
{
    public function __construct(
        private readonly BillingService $billingService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->integer('per_page', 15);
        $paginated = $this->billingService->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Daftar invoice berhasil diambil.',
            'data' => InvoiceResource::collection($paginated->getCollection()),
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
            'message' => 'Detail invoice berhasil diambil.',
            'data' => new InvoiceResource($this->billingService->find($id)),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'pasien_id' => ['required', 'integer', 'min:1'],
            'deskripsi_layanan' => ['required', 'string', 'max:255'],
            'subtotal' => ['required', 'numeric', 'min:0'],
            'catatan' => ['nullable', 'string'],
        ]);

        $invoice = $this->billingService->createInvoice(CreateInvoiceDTO::fromRequest($request));

        return response()->json([
            'success' => true,
            'message' => 'Invoice berhasil dibuat.',
            'data' => new InvoiceResource($invoice),
        ], 201);
    }
}
