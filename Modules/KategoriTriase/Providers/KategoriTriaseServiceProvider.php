<?php
/**
 * ============================================================
 * @module      KategoriTriase
 * @layer       Provider
 * @file        KategoriTriaseServiceProvider.php
 * @path        Modules/KategoriTriase/Providers/KategoriTriaseServiceProvider.php
 * @description Bootstrap modul KategoriTriase. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) -- KategoriTriaseService type-hint langsung
 *              ke KategoriTriaseRepository konkret, Laravel container resolve
 *              otomatis. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\KategoriTriase\Providers;

use Modules\BaseServiceProvider;

final class KategoriTriaseServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
