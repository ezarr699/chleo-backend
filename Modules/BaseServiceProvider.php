<?php
/**
 * ============================================================
 * @module      Core
 * @layer       Provider (Base)
 * @file        BaseServiceProvider.php
 * @path        Modules/BaseServiceProvider.php
 * @description Kelas dasar untuk seluruh ServiceProvider modul Clean
 *              Architecture (root Modules/). Mengotomasi 2 hal supaya
 *              modul baru tidak perlu mendaftarkan apapun secara manual:
 *
 *              1) Routes — Routes/api.php (kalau ada) didaftarkan sebagai
 *                 rute central berprefix "api/v1", TANPA middleware
 *                 tenancy. Routes/tenant.php (kalau ada) didaftarkan
 *                 berprefix "api/v1" DENGAN middleware inisialisasi
 *                 tenancy (identik dengan yang dipakai routes/api.php
 *                 pusat untuk modul lama di app/Modules/), supaya data
 *                 tenant tidak pernah bocor ke domain central. Middleware
 *                 group "api" WAJIB disertakan secara eksplisit di sini —
 *                 bootstrap/app.php mendaftarkan grup itu lewat
 *                 withRouting(api: routes/api.php), yang HANYA berlaku
 *                 untuk route yang didaftarkan di dalam file itu sendiri
 *                 (termasuk yang di-require lewat glob app/Modules/*).
 *                 Route yang didaftarkan dari ServiceProvider::boot() ada
 *                 di luar konteks itu, jadi prefix "api" dan middleware
 *                 group "api"-nya tidak otomatis ikut — harus ditambahkan
 *                 manual di sini supaya modul baru & modul lama
 *                 menghasilkan URL dan middleware stack yang identik.
 *
 *              2) Migrations — Database/Migrations/*.php (file langsung
 *                 di root folder ini, BUKAN di subfolder tenant/) di-load
 *                 lewat loadMigrationsFrom() untuk tabel CENTRAL biasa.
 *                 Database/Migrations/tenant/*.php SENGAJA TIDAK di-load
 *                 di sini — kalau di-load lewat loadMigrationsFrom() dia
 *                 akan otomatis ikut migration command biasa (koneksi
 *                 central), padahal tabel di situ HARUS hanya dibuat di
 *                 database tenant. Path tenant/ dibaca terpisah oleh
 *                 stancl/tenancy lewat config/tenancy.php
 *                 (migration_parameters.--path) dan hanya jalan lewat
 *                 `php artisan tenants:migrate`.
 *
 *              $modulePath dihitung otomatis lewat ReflectionClass —
 *              provider modul turunan (mis. BillingServiceProvider)
 *              tidak perlu hardcode path/nama modulnya sendiri.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://laravel.com/docs/13.x/packages#routes
 *              https://laravel.com/docs/13.x/packages#migrations
 * ============================================================
 */

declare(strict_types=1);

namespace Modules;

use Modules\Tenancy\Http\Middleware\EnsureTenantNotSuspended;
use Modules\Tenancy\Http\Middleware\InitializeTenancyByHostWithLocalhostFallback;
use Modules\Tenancy\Http\Middleware\PreventAccessFromCentralDomainsExceptLocalhostFallback;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;

abstract class BaseServiceProvider extends ServiceProvider
{
    private readonly string $modulePath;

    public function __construct($app)
    {
        parent::__construct($app);

        // Provider turunan selalu berada di Modules/{Modul}/Providers/{Modul}ServiceProvider.php
        // -> dua tingkat di atas file provider adalah root folder modul tersebut.
        $this->modulePath = dirname((new ReflectionClass($this))->getFileName(), 2);
    }

    public function boot(): void
    {
        $this->bootModuleRoutes();
        $this->bootModuleMigrations();
    }

    private function bootModuleRoutes(): void
    {
        $centralRoutes = $this->modulePath.'/Routes/api.php';

        if (is_file($centralRoutes)) {
            Route::prefix('api/v1')->middleware('api')->group($centralRoutes);
        }

        $tenantRoutes = $this->modulePath.'/Routes/tenant.php';

        if (is_file($tenantRoutes)) {
            Route::prefix('api/v1')
                ->middleware([
                    'api',
                    InitializeTenancyByHostWithLocalhostFallback::class,
                    PreventAccessFromCentralDomainsExceptLocalhostFallback::class,
                    EnsureTenantNotSuspended::class,
                ])
                ->group($tenantRoutes);
        }
    }

    private function bootModuleMigrations(): void
    {
        $centralMigrations = $this->modulePath.'/Database/Migrations';

        if (is_dir($centralMigrations)) {
            $this->loadMigrationsFrom($centralMigrations);
        }
    }
}
