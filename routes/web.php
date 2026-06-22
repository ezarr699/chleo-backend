<?php
/**
 * ============================================================
 * @layer       Route
 * @file        web.php
 * @path        routes/web.php
 * @description Selain halaman welcome default, mendaftarkan ulang
 *              GET /sanctum/csrf-cookie (auto-route Sanctum dimatikan
 *              lewat config('sanctum.routes') = false) di bawah
 *              InitializeTenancyBySubdomain, supaya sesi CSRF dibaca/
 *              ditulis ke database tenant yang benar, bukan central.
 * @ref         https://laravel.com/docs/13.x/sanctum#spa-authenticating
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use Modules\Tenancy\Http\Middleware\EnsureTenantNotSuspended;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([InitializeTenancyBySubdomain::class, PreventAccessFromCentralDomains::class, EnsureTenantNotSuspended::class])
    ->get('sanctum/csrf-cookie', [CsrfCookieController::class, 'show'])
    ->name('sanctum.csrf-cookie');
