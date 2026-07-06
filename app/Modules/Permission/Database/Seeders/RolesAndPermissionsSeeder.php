<?php
/**
 * ============================================================
 * @module      Permission
 * @layer       Database > Seeder (Tenant)
 * @file        RolesAndPermissionsSeeder.php
 * @path        app/Modules/Permission/Database/Seeders/RolesAndPermissionsSeeder.php
 * @description Membuat 2 permission per modul data master (.view dan
 *              .manage), permission ekstra di EXTRA_PERMISSIONS untuk
 *              modul yang punya aksi lebih dari CRUD biasa (mis.
 *              pasien.verifikasi), dan satu role "admin" yang punya
 *              semua permission tersebut. Idempotent
 *              (firstOrCreate/syncPermissions) — aman dipanggil
 *              berulang. Harus dijalankan di DALAM tenant->run() karena
 *              roles/permissions bersifat per-tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Permission\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    private const MODULES = [
        'golongan_darah',
        'jenis_kelamin',
        'penjamin',
        'asuransi',
        'pasien',
    ];

    /**
     * Permission tambahan untuk modul dengan aksi di luar view/manage.
     */
    private const EXTRA_PERMISSIONS = [
        'pasien.verifikasi',
    ];

    public function run(): void
    {
        $names = [];

        foreach (self::MODULES as $module) {
            $names[] = "{$module}.view";
            $names[] = "{$module}.manage";
        }

        $names = [...$names, ...self::EXTRA_PERMISSIONS];

        foreach ($names as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web'])->syncPermissions($names);
    }
}
