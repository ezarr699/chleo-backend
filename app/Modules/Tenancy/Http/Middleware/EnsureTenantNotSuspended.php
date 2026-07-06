<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Middleware
 * @file        EnsureTenantNotSuspended.php
 * @path        app/Modules/Tenancy/Http/Middleware/EnsureTenantNotSuspended.php
 * @description Menolak seluruh request ke database tenant yang sedang
 *              di-suspend (tenants.suspended_at terisi) lewat aplikasi
 *              admin pusat. Harus berjalan SETELAH tenancy diinisialisasi
 *              (InitializeTenancyBySubdomain) supaya helper tenant()
 *              tersedia.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Tenancy\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureTenantNotSuspended
{
    public function handle(Request $request, Closure $next): Response
    {
        if (tenant() && tenant()->suspended_at !== null) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Akun perusahaan ini sedang ditangguhkan.',
                'errors' => null,
                'code' => 'tenant_suspended',
            ], 403));
        }

        return $next($request);
    }
}
