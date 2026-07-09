<?php
/**
 * ============================================================
 * @module      StatusPerkawinan
 * @layer       Provider
 * @file        StatusPerkawinanServiceProvider.php
 * @path        Modules/StatusPerkawinan/Providers/StatusPerkawinanServiceProvider.php
 * @description Bootstrap modul StatusPerkawinan. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) -- StatusPerkawinanService type-hint langsung
 *              ke StatusPerkawinanRepository konkret, Laravel container resolve
 *              otomatis. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\StatusPerkawinan\Providers;

use Modules\BaseServiceProvider;

final class StatusPerkawinanServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
