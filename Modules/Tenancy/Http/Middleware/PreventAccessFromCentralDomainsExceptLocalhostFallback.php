<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Middleware
 * @file        PreventAccessFromCentralDomainsExceptLocalhostFallback.php
 * @path        Modules/Tenancy/Http/Middleware/PreventAccessFromCentralDomainsExceptLocalhostFallback.php
 * @description Sama seperti Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains,
 *              tapi membuat pengecualian untuk host "localhost" polos
 *              ketika config('tenancy.localhost_fallback_tenant') diisi.
 *              "localhost" tetap terdaftar di tenancy.central_domains
 *              (dibutuhkan EnsureCentralDomain untuk endpoint provisioning
 *              tenant yang dipanggil chleo-admin-backend), tapi route
 *              tenant (mis. auth login) perlu tetap bisa diakses lewat
 *              host yang sama saat fallback development ini aktif.
 *              Dipasangkan dengan
 *              InitializeTenancyByHostWithLocalhostFallback yang
 *              menginisialisasi tenancy untuk host tersebut terlebih
 *              dahulu. Kalau config kosong (default), perilaku identik
 *              dengan middleware aslinya.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://tenancyforlaravel.com/docs/v3/identification/#central-domains
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Tenancy\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Symfony\Component\HttpFoundation\Response;

final class PreventAccessFromCentralDomainsExceptLocalhostFallback extends PreventAccessFromCentralDomains
{
    public function handle(Request $request, Closure $next): Response
    {
        $fallbackTenant = config('tenancy.localhost_fallback_tenant');
        $fallbackHosts = config('tenancy.localhost_fallback_hosts', ['localhost']);

        if (filled($fallbackTenant) && in_array($request->getHost(), $fallbackHosts, true)) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
