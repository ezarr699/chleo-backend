<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Controller
 * @file        TenantManagementController.php
 * @path        Modules/Tenancy/Controllers/TenantManagementController.php
 * @description Handle HTTP request manajemen tenant dari aplikasi admin
 *              pusat: list, detail, suspend/resume, hapus, statistik.
 *              Hanya dipanggil di domain central, digerbangi middleware
 *              RequireManagementToken.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Tenancy\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Tenancy\Requests\UpdateTenantAdminRequest;
use Modules\Tenancy\Requests\UpdateTenantSuspensionRequest;
use Modules\Tenancy\Resources\TenantResource;
use Modules\Tenancy\Services\TenantManagementService;

final class TenantManagementController extends Controller
{
    public function __construct(
        private readonly TenantManagementService $tenantManagementService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->integer('per_page', 15);
        $paginated = $this->tenantManagementService->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Daftar tenant berhasil diambil.',
            'data' => TenantResource::collection($paginated->getCollection()),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ],
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $tenant = $this->tenantManagementService->find($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail tenant berhasil diambil.',
            'data' => new TenantResource($tenant),
        ]);
    }

    public function update(UpdateTenantSuspensionRequest $request, string $id): JsonResponse
    {
        $tenant = $this->tenantManagementService->setSuspended($id, $request->boolean('suspended'));

        return response()->json([
            'success' => true,
            'message' => $tenant->suspended_at !== null
                ? 'Tenant berhasil ditangguhkan.'
                : 'Tenant berhasil diaktifkan kembali.',
            'data' => new TenantResource($tenant),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->tenantManagementService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Tenant berhasil dihapus.',
            'data' => null,
        ]);
    }

    public function restore(string $id): JsonResponse
    {
        $tenant = $this->tenantManagementService->restore($id);

        return response()->json([
            'success' => true,
            'message' => 'Tenant berhasil dipulihkan.',
            'data' => new TenantResource($tenant),
        ]);
    }

    public function updateDetails(UpdateTenantAdminRequest $request, string $id): JsonResponse
    {
        $tenant = $this->tenantManagementService->updateAdminDetails(
            $id,
            $request->array('admin'),
        );

        return response()->json([
            'success' => true,
            'message' => 'Detail admin tenant berhasil diperbarui.',
            'data' => new TenantResource($tenant),
        ]);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Statistik tenant berhasil diambil.',
            'data' => $this->tenantManagementService->stats(),
        ]);
    }
}
