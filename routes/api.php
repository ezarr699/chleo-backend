<?php
/**
 * ============================================================
 * @layer       Route
 * @file        api.php
 * @path        routes/api.php
 * @description Aggregator dua jalur:
 *              - Modules/*\/Routes/api.php  -> central-domain-only,
 *                TIDAK menjalankan tenancy initialization (mis. provisioning
 *                tenant baru di Modules/Tenancy).
 *              - Modules/*\/Routes/tenant.php -> dijalankan dengan
 *                InitializeTenancyBySubdomain (database tenant aktif),
 *                dipakai semua modul yang butuh akses data tenant
 *                (mis. Auth: login/logout/me).
 * @ref         https://laravel.com/docs/13.x/routing
 *              https://tenancyforlaravel.com/docs/v3/
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\Tenancy\Http\Middleware\EnsureTenantNotSuspended;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

foreach (glob(base_path('Modules/*/Routes/api.php')) as $moduleRoutes) {
    Route::prefix('v1')->group($moduleRoutes);
}

foreach (glob(base_path('Modules/*/Routes/tenant.php')) as $tenantRoutes) {
    Route::prefix('v1')
        ->middleware([InitializeTenancyBySubdomain::class, PreventAccessFromCentralDomains::class, EnsureTenantNotSuspended::class])
        ->group($tenantRoutes);
}
