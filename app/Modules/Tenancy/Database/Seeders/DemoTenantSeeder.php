<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Database > Seeder (Tenant)
 * @file        DemoTenantSeeder.php
 * @path        app/Modules/Tenancy/Database/Seeders/DemoTenantSeeder.php
 * @description Membuat tenant contoh "demo" (demo.localhost) untuk
 *              keperluan development lokal, lalu men-seed role/permission
 *              dan admin user di DALAM database tenant tersebut (bukan
 *              central). Login admin@chleo.test tetap berfungsi seperti
 *              sebelum tenancy ditambahkan, sekarang lewat
 *              http://demo.localhost, dan otomatis punya role "admin".
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Modules\Tenancy\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use App\Modules\Permission\Database\Seeders\RolesAndPermissionsSeeder;
use App\Modules\Tenancy\Models\Tenant;

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
                '--path' => 'database/migrations/tenant',
                '--force' => true,
            ]);

            (new RolesAndPermissionsSeeder())->run();

            $admin = User::where('email', 'admin@chleo.test')->first()
                ?? User::factory()->create([
                    'name' => 'Admin Chleo',
                    'email' => 'admin@chleo.test',
                    'password' => Hash::make('password'),
                ]);

            if (! $admin->hasRole('admin')) {
                $admin->assignRole('admin');
            }
        });
    }
}
