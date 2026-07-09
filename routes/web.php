<?php
/**
 * ============================================================
 * @layer       Route
 * @file        web.php
 * @path        routes/web.php
 * @description Mendaftarkan ulang GET /sanctum/csrf-cookie (auto-route
 *              Sanctum dimatikan lewat config('sanctum.routes') = false)
 *              di bawah InitializeTenancyBySubdomain, supaya sesi CSRF
 *              dibaca/ditulis ke database tenant yang benar, bukan
 *              central.
 *              SENGAJA tidak ada route GET / (placeholder welcome bawaan
 *              Laravel sudah dihapus) — backend ini API-only, diakses
 *              cuma lewat /api/v1/* dan /sanctum/csrf-cookie oleh
 *              frontend SPA yang jalan di domain/port terpisah. Hit
 *              langsung ke domain backend tanpa tenancy diinisialisasi
 *              akan jatuh ke 'web' middleware group bawaan (StartSession,
 *              dst.) yang mencoba query tabel `sessions` di koneksi
 *              central — central tidak punya tabel itu karena sesi
 *              bersifat per-tenant, jadi akan 500. Lebih aman 404 bersih
 *              daripada route yang setengah jalan kena middleware itu.
 *              InitializeTenancyBySubdomain/PreventAccessFromCentralDomains
 *              dipakai lewat varian *WithLocalhostFallback di
 *              Modules/Tenancy — identik dengan aslinya kecuali
 *              tenancy.localhost_fallback_tenant diisi di .env (dev only).
 * @ref         https://laravel.com/docs/13.x/sanctum#spa-authenticating
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use Modules\Tenancy\Http\Middleware\EnsureTenantNotSuspended;
use Modules\Tenancy\Http\Middleware\InitializeTenancyByHostWithLocalhostFallback;
use Modules\Tenancy\Http\Middleware\PreventAccessFromCentralDomainsExceptLocalhostFallback;

Route::middleware([InitializeTenancyByHostWithLocalhostFallback::class, PreventAccessFromCentralDomainsExceptLocalhostFallback::class, EnsureTenantNotSuspended::class])
    ->get('sanctum/csrf-cookie', [CsrfCookieController::class, 'show'])
    ->name('sanctum.csrf-cookie');
