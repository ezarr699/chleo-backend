<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Database > Seeder (Tenant)
 * @file        DemoTenantSeeder.php
 * @path        Modules/Tenancy/Database/Seeders/DemoTenantSeeder.php
 * @description Membuat tenant contoh "demo" (demo.localhost) untuk
 *              keperluan development lokal, lalu men-seed role/permission
 *              dan admin user di DALAM database tenant tersebut (bukan
 *              central). Login admin@chleo.test tetap berfungsi seperti
 *              sebelum tenancy ditambahkan, sekarang lewat
 *              http://demo.localhost, dan otomatis punya role "admin".
 *              --path migrasi diambil dari config('tenancy.migration_parameters')
 *              (BUKAN hardcode 'database/migrations/tenant') supaya ikut
 *              memuat migrasi tenant milik modul Clean Architecture
 *              generasi baru di root Modules/*\/Database/Migrations/tenant
 *              juga — hardcode lama diam-diam melewatkannya.
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\Tenancy\Database\Seeders;

use Modules\Permission\Database\Seeders\RolesAndPermissionsSeeder;
use Modules\Tenancy\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Modules\Icd10\Database\Seeders\Icd10Seeder;
use Modules\Shared\Contracts\UserProvisioningInterface;

class DemoTenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::query()->find('demo') ?? Tenant::create(['id' => 'demo']);

        if ($tenant->domains()->count() === 0) {
            $tenant->domains()->create(['domain' => 'demo']);
        }

        $tenant->run(function () {
            Artisan::call('migrate', [
                '--path' => config('tenancy.migration_parameters')['--path'],
                '--force' => true,
                '--realpath' => true,
            ]);

            (new RolesAndPermissionsSeeder())->run();
            (new Icd10Seeder())->run();

            app(UserProvisioningInterface::class)->ensureAdminExists('Admin Chleo', 'admin@chleo.test', 'password');
        });
    }
}
