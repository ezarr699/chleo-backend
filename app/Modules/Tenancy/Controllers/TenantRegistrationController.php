<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Controller
 * @file        TenantRegistrationController.php
 * @path        app/Modules/Tenancy/Controllers/TenantRegistrationController.php
 * @description Handle HTTP request provisioning tenant baru. Hanya
 *              dipanggil di domain central, digerbangi middleware
 *              RequireManagementToken (admin-gated).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Tenancy\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Modules\Tenancy\Requests\RegisterTenantRequest;
use App\Modules\Tenancy\Resources\TenantResource;
use App\Modules\Tenancy\Services\TenantProvisioningService;

final class TenantRegistrationController extends Controller
{
    public function __construct(
        private readonly TenantProvisioningService $tenantProvisioningService,
    ) {}

    public function store(RegisterTenantRequest $request): JsonResponse
    {
        $tenant = $this->tenantProvisioningService->provision(
            $request->string('slug')->toString(),
            $request->array('admin'),
        );

        return response()->json([
            'success' => true,
            'message' => 'Tenant berhasil dibuat.',
            'data' => new TenantResource($tenant->load('domains')),
        ], 201);
    }
}
