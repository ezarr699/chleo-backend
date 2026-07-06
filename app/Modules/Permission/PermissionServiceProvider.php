<?php
/**
 * ============================================================
 * @module      Permission
 * @layer       Provider
 * @file        PermissionServiceProvider.php
 * @path        app/Modules/Permission/PermissionServiceProvider.php
 * @description Modul ini tidak punya CRUD/business logic sendiri —
 *              hanya menjadi rumah untuk seeding role/permission
 *              (RolesAndPermissionsSeeder) dan listener cache
 *              spatie/laravel-permission supaya aman dipakai bersama
 *              database-per-tenant (lihat FlushPermissionCache).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Permission;

use Illuminate\Support\ServiceProvider;

final class PermissionServiceProvider extends ServiceProvider
{
    public function register(): void {}
}
