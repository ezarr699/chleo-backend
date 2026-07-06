<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Middleware
 * @file        RequireManagementToken.php
 * @path        app/Modules/Tenancy/Http/Middleware/RequireManagementToken.php
 * @description Menggerbangi seluruh endpoint manajemen tenant (provisioning,
 *              list, suspend/resume, hapus, domain) dengan shared secret
 *              yang dikirim lewat header X-Management-Token. Dipanggil oleh
 *              aplikasi admin pusat (chleo-admin-backend) secara
 *              server-to-server — bukan auth user, bukan self-service publik.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Tenancy\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class RequireManagementToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('X-Management-Token');
        $expected = config('tenancy.management_token');

        if (! $expected || ! $token || ! hash_equals($expected, $token)) {
            abort(403, 'Token manajemen tidak valid.');
        }

        return $next($request);
    }
}
