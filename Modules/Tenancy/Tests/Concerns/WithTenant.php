<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Test > Concern
 * @file        WithTenant.php
 * @path        Modules/Tenancy/Tests/Concerns/WithTenant.php
 * @description Trait Pest untuk membuat tenant + jalankan migrasi
 *              tenant di dalam test, dan menjalankan callback di
 *              dalam konteks database tenant tersebut. Dipakai oleh
 *              test modul mana pun yang butuh konteks tenant
 *              (mis. Modules/Auth/Tests/Feature/LoginTest.php).
 *              --path migrasi diambil dari config('tenancy.migration_parameters')
 *              (BUKAN hardcode 'database/migrations/tenant') supaya ikut
 *              memuat migrasi tenant milik modul Clean Architecture
 *              generasi baru di root Modules/*\/Database/Migrations/tenant
 *              juga — hardcode lama diam-diam melewatkannya, yang berarti
 *              SEMUA test modul baru (Pasien, Registrasi, RawatJalan, dst)
 *              akan gagal karena tabelnya sendiri tidak pernah ter-migrate.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\Tenancy\Tests\Concerns;

use Modules\Tenancy\Models\Tenant;

trait WithTenant
{
    protected Tenant $tenant;

    protected function createTenant(string $subdomain = 'test-tenant'): Tenant
    {
        $this->tenant = Tenant::create(['id' => $subdomain]);
        $this->tenant->domains()->create(['domain' => $subdomain]);

        $this->tenant->run(function () {
            $this->artisan('migrate', [
                '--path' => config('tenancy.migration_parameters')['--path'],
                '--realpath' => true,
            ]);
        });

        return $this->tenant;
    }

    protected function asTenant(callable $callback): mixed
    {
        return $this->tenant->run($callback);
    }
}
