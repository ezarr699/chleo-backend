<?php
/**
 * ============================================================
 * @layer       Route
 * @file        api.php
 * @path        routes/api.php
 * @description Aggregator dua jalur:
 *              - app/Modules/*\/Routes/api.php  -> central-domain-only,
 *                TIDAK menjalankan tenancy initialization (mis. provisioning
 *                tenant baru di app/Modules/Tenancy).
 *              - app/Modules/*\/Routes/tenant.php -> dijalankan dengan
 *                InitializeTenancyBySubdomain (database tenant aktif),
 *                dipakai semua modul yang butuh akses data tenant
 *                (mis. Auth: login/logout/me).
 *              InitializeTenancyBySubdomain/PreventAccessFromCentralDomains
 *              dipakai lewat varian *WithLocalhostFallback di
 *              Modules/Tenancy — identik dengan aslinya kecuali
 *              tenancy.localhost_fallback_tenant diisi di .env (dev only,
 *              supaya bisa akses tanpa subdomain tenant).
 * @ref         https://laravel.com/docs/13.x/routing
 *              https://tenancyforlaravel.com/docs/v3/
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use App\Modules\Tenancy\Http\Middleware\EnsureTenantNotSuspended;
use App\Modules\Tenancy\Http\Middleware\InitializeTenancyByHostWithLocalhostFallback;
use App\Modules\Tenancy\Http\Middleware\PreventAccessFromCentralDomainsExceptLocalhostFallback;

foreach (glob(base_path('app/Modules/*/Routes/api.php')) as $moduleRoutes) {
    Route::prefix('v1')->group($moduleRoutes);
}

foreach (glob(base_path('app/Modules/*/Routes/tenant.php')) as $tenantRoutes) {
    Route::prefix('v1')
        ->middleware([InitializeTenancyByHostWithLocalhostFallback::class, PreventAccessFromCentralDomainsExceptLocalhostFallback::class, EnsureTenantNotSuspended::class])
        ->group($tenantRoutes);
}
