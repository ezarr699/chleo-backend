<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Controller
 * @file        TenantDomainController.php
 * @path        app/Modules/Tenancy/Controllers/TenantDomainController.php
 * @description Handle HTTP request manajemen domain tenant dari aplikasi
 *              admin pusat: tambah dan hapus domain. Hanya dipanggil di
 *              domain central, digerbangi middleware RequireManagementToken.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Tenancy\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Modules\Tenancy\Requests\StoreTenantDomainRequest;
use App\Modules\Tenancy\Resources\TenantResource;
use App\Modules\Tenancy\Services\TenantManagementService;

final class TenantDomainController extends Controller
{
    public function __construct(
        private readonly TenantManagementService $tenantManagementService,
    ) {}

    public function store(StoreTenantDomainRequest $request, string $tenantId): JsonResponse
    {
        $this->tenantManagementService->addDomain($tenantId, $request->string('domain')->toString());

        return response()->json([
            'success' => true,
            'message' => 'Domain berhasil ditambahkan.',
            'data' => new TenantResource($this->tenantManagementService->find($tenantId)),
        ], 201);
    }

    public function destroy(string $tenantId, int $domainId): JsonResponse
    {
        $this->tenantManagementService->removeDomain($tenantId, $domainId);

        return response()->json([
            'success' => true,
            'message' => 'Domain berhasil dihapus.',
            'data' => new TenantResource($this->tenantManagementService->find($tenantId)),
        ]);
    }
}
