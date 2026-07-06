<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Test > Concern
 * @file        WithTenant.php
 * @path        app/Modules/Tenancy/Tests/Concerns/WithTenant.php
 * @description Trait Pest untuk membuat tenant + jalankan migrasi
 *              tenant di dalam test, dan menjalankan callback di
 *              dalam konteks database tenant tersebut. Dipakai oleh
 *              test modul mana pun yang butuh konteks tenant
 *              (mis. Modules/Auth/Tests/Feature/LoginTest.php).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Modules\Tenancy\Tests\Concerns;

use App\Modules\Tenancy\Models\Tenant;

trait WithTenant
{
    protected Tenant $tenant;

    protected function createTenant(string $subdomain = 'test-tenant'): Tenant
    {
        $this->tenant = Tenant::create(['id' => $subdomain]);
        $this->tenant->domains()->create(['domain' => $subdomain]);

        $this->tenant->run(function () {
            $this->artisan('migrate', [
                '--path' => 'database/migrations/tenant',
                '--realpath' => false,
            ]);
        });

        return $this->tenant;
    }

    protected function asTenant(callable $callback): mixed
    {
        return $this->tenant->run($callback);
    }
}
