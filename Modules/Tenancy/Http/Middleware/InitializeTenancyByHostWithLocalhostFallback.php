<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Middleware
 * @file        InitializeTenancyByHostWithLocalhostFallback.php
 * @path        Modules/Tenancy/Http/Middleware/InitializeTenancyByHostWithLocalhostFallback.php
 * @description Sama seperti Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain,
 *              tapi khusus untuk kenyamanan development lokal: kalau
 *              request masuk lewat host "localhost" polos (tanpa
 *              subdomain tenant, mis. bukan demo.localhost) DAN
 *              config('tenancy.localhost_fallback_tenant') diisi, tenancy
 *              langsung diinisialisasi ke tenant tersebut tanpa perlu
 *              subdomain sama sekali. Kalau config itu kosong (default di
 *              .env.example), perilaku 100% identik dengan middleware
 *              aslinya — fallback ini sepenuhnya opt-in lewat env, jadi
 *              tidak mengubah apa pun di staging/production yang memang
 *              mengharuskan subdomain tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://tenancyforlaravel.com/docs/v3/identification/#subdomain-identification
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Tenancy\Http\Middleware;

use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;

final class InitializeTenancyByHostWithLocalhostFallback extends InitializeTenancyBySubdomain
{
    /** @return string|\Exception|mixed */
    protected function makeSubdomain(string $hostname)
    {
        $fallbackTenant = config('tenancy.localhost_fallback_tenant');
        $fallbackHosts = config('tenancy.localhost_fallback_hosts', ['localhost']);

        if (filled($fallbackTenant) && in_array($hostname, $fallbackHosts, true)) {
            return $fallbackTenant;
        }

        return parent::makeSubdomain($hostname);
    }
}
