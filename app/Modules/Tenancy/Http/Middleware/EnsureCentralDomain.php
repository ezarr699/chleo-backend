<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Middleware
 * @file        EnsureCentralDomain.php
 * @path        app/Modules/Tenancy/Http/Middleware/EnsureCentralDomain.php
 * @description Menolak request yang masuk lewat subdomain tenant
 *              (mis. acme.localhost) ke route central-only seperti
 *              provisioning tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Tenancy\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureCentralDomain
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->getHost(), config('tenancy.central_domains'), true)) {
            abort(404);
        }

        return $next($request);
    }
}
