<?php
/**
 * ============================================================
 * @module      Permission
 * @layer       Provider
 * @file        PermissionServiceProvider.php
 * @path        Modules/Permission/Providers/PermissionServiceProvider.php
 * @description Modul ini tidak punya CRUD/business logic sendiri — hanya
 *              rumah untuk seeding role/permission
 *              (RolesAndPermissionsSeeder, dipakai langsung lewat
 *              instantiate manual di test & Tenancy, bukan lewat
 *              container) dan listener cache spatie/laravel-permission
 *              (FlushPermissionCache, didaftarkan oleh
 *              Tenancy\TenancyServiceProvider ke event TenancyEnded).
 *              Tidak ada Routes/Database/Migrations, jadi
 *              parent::boot() (Modules/BaseServiceProvider.php) jadi
 *              no-op — provider ini tetap dibuat untuk konsistensi
 *              struktur modul.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Permission\Providers;

use Modules\BaseServiceProvider;

final class PermissionServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
