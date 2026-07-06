<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Database > Seeder (Central)
 * @file        DatabaseSeeder.php
 * @path        database/seeders/DatabaseSeeder.php
 * @description Root seeder database CENTRAL. Tidak ada tabel users di
 *              central (database-per-tenant) — seeding user dilakukan
 *              di dalam DemoTenantSeeder, terbungkus tenant->run().
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Tenancy\Database\Seeders\DemoTenantSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(DemoTenantSeeder::class);
    }
}
