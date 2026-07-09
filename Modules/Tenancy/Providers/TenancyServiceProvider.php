<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Provider
 * @file        TenancyServiceProvider.php
 * @path        Modules/Tenancy/Providers/TenancyServiceProvider.php
 * @description Bootstrap modul Tenancy: event listener stancl/tenancy
 *              (create/migrate/delete database tenant). Tidak ada lagi
 *              binding TenantRepositoryInterface (Contracts/ dihapus) —
 *              TenantManagementService/TenantProvisioningService
 *              type-hint langsung ke TenantRepository konkret. Extends
 *              BaseServiceProvider supaya Routes/api.php (central,
 *              provisioning/manajemen tenant) dan Database/Migrations/
 *              (tabel tenants) otomatis ter-load seperti modul lain —
 *              parent::boot() dipanggil sebelum logic event/middleware
 *              tenancy milik provider ini sendiri. Wildcard subdomain
 *              untuk Sanctum stateful check sudah didukung native oleh
 *              Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful
 *              (pakai Str::is()), jadi tidak perlu override — cukup
 *              SANCTUM_STATEFUL_DOMAINS diisi pattern `*.localhost:3000`.
 *              Direlokasi dari scaffold default `tenancy:install`
 *              (app/Providers/TenancyServiceProvider.php) supaya
 *              mengikuti konvensi Modules/* di proyek ini.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://tenancyforlaravel.com/docs/v3/
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Tenancy\Providers;

use Illuminate\Support\Facades\Event;
use Modules\BaseServiceProvider;
use Modules\Permission\Listeners\FlushPermissionCache;
use Stancl\JobPipeline\JobPipeline;
use Stancl\Tenancy\Events;
use Stancl\Tenancy\Jobs;
use Stancl\Tenancy\Listeners;
use Stancl\Tenancy\Middleware;

class TenancyServiceProvider extends BaseServiceProvider
{
    // By default, no namespace is used to support the callable array syntax.
    public static string $controllerNamespace = '';

    public function events()
    {
        return [
            // Tenant events
            Events\CreatingTenant::class => [],
            Events\TenantCreated::class => config('tenancy.single_database', false) ? [] : [
                JobPipeline::make([
                    Jobs\CreateDatabase::class,
                    Jobs\MigrateDatabase::class,
                    // Jobs\SeedDatabase::class,

                    // Your own jobs to prepare the tenant.
                    // Provision API keys, create S3 buckets, anything you want!

                ])->send(function (Events\TenantCreated $event) {
                    return $event->tenant;
                })->shouldBeQueued(false), // `false` by default, but you probably want to make this `true` for production.
            ],
            Events\SavingTenant::class => [],
            Events\TenantSaved::class => [],
            Events\UpdatingTenant::class => [],
            Events\TenantUpdated::class => [],
            Events\DeletingTenant::class => [],
            Events\TenantDeleted::class => config('tenancy.single_database', false) ? [] : [
                JobPipeline::make([
                    Jobs\DeleteDatabase::class,
                ])->send(function (Events\TenantDeleted $event) {
                    return $event->tenant;
                })->shouldBeQueued(false), // `false` by default, but you probably want to make this `true` for production.
            ],

            // Domain events
            Events\CreatingDomain::class => [],
            Events\DomainCreated::class => [],
            Events\SavingDomain::class => [],
            Events\DomainSaved::class => [],
            Events\UpdatingDomain::class => [],
            Events\DomainUpdated::class => [],
            Events\DeletingDomain::class => [],
            Events\DomainDeleted::class => [],

            // Database events
            Events\DatabaseCreated::class => [],
            Events\DatabaseMigrated::class => [],
            Events\DatabaseSeeded::class => [],
            Events\DatabaseRolledBack::class => [],
            Events\DatabaseDeleted::class => [],

            // Tenancy events
            Events\InitializingTenancy::class => [],
            Events\TenancyInitialized::class => [
                Listeners\BootstrapTenancy::class,
                FlushPermissionCache::class,
            ],

            Events\EndingTenancy::class => [],
            Events\TenancyEnded::class => [
                Listeners\RevertToCentralContext::class,
                FlushPermissionCache::class,
            ],

            Events\BootstrappingTenancy::class => [],
            Events\TenancyBootstrapped::class => [],
            Events\RevertingToCentralContext::class => [],
            Events\RevertedToCentralContext::class => [],

            // Resource syncing
            Events\SyncedResourceSaved::class => [
                Listeners\UpdateSyncedResource::class,
            ],

            // Fired only when a synced resource is changed in a different DB than the origin DB (to avoid infinite loops)
            Events\SyncedResourceChangedInForeignDatabase::class => [],
        ];
    }

    public function register(): void {}

    public function boot(): void
    {
        parent::boot();

        $this->bootEvents();

        $this->makeTenancyMiddlewareHighestPriority();
    }

    protected function bootEvents()
    {
        foreach ($this->events() as $event => $listeners) {
            foreach ($listeners as $listener) {
                if ($listener instanceof JobPipeline) {
                    $listener = $listener->toListener();
                }

                Event::listen($event, $listener);
            }
        }
    }

    protected function makeTenancyMiddlewareHighestPriority()
    {
        $tenancyMiddleware = [
            // Even higher priority than the initialization middleware
            Middleware\PreventAccessFromCentralDomains::class,

            Middleware\InitializeTenancyByDomain::class,
            Middleware\InitializeTenancyBySubdomain::class,
            Middleware\InitializeTenancyByDomainOrSubdomain::class,
            Middleware\InitializeTenancyByPath::class,
            Middleware\InitializeTenancyByRequestData::class,
        ];

        foreach (array_reverse($tenancyMiddleware) as $middleware) {
            $this->app[\Illuminate\Contracts\Http\Kernel::class]->prependToMiddlewarePriority($middleware);
        }
    }
}
