<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Route
 * @file        api.php
 * @path        Modules/Tenancy/Routes/api.php
 * @description Route HTTP central-only (TIDAK menjalankan tenancy
 *              initialization) untuk provisioning dan manajemen tenant.
 *              Dipanggil oleh aplikasi admin pusat (chleo-admin-backend)
 *              server-to-server, digerbangi RequireManagementToken.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\Tenancy\Controllers\TenantDomainController;
use Modules\Tenancy\Controllers\TenantManagementController;
use Modules\Tenancy\Controllers\TenantRegistrationController;
use Modules\Tenancy\Http\Middleware\EnsureCentralDomain;
use Modules\Tenancy\Http\Middleware\RequireManagementToken;

Route::middleware([EnsureCentralDomain::class, RequireManagementToken::class])->group(function () {
    Route::post('tenants', [TenantRegistrationController::class, 'store']);

    Route::get('tenants', [TenantManagementController::class, 'index']);
    Route::get('tenants/stats', [TenantManagementController::class, 'stats']);
    Route::get('tenants/{id}', [TenantManagementController::class, 'show']);
    Route::put('tenants/{id}', [TenantManagementController::class, 'updateDetails']);
    Route::patch('tenants/{id}', [TenantManagementController::class, 'update']);
    Route::delete('tenants/{id}', [TenantManagementController::class, 'destroy']);
    Route::post('tenants/{id}/restore', [TenantManagementController::class, 'restore']);

    Route::post('tenants/{tenantId}/domains', [TenantDomainController::class, 'store']);
    Route::delete('tenants/{tenantId}/domains/{domainId}', [TenantDomainController::class, 'destroy']);
});
