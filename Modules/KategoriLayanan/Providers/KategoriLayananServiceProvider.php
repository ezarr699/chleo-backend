<?php
/**
 * ============================================================
 * @module      KategoriLayanan
 * @layer       Provider
 * @file        KategoriLayananServiceProvider.php
 * @path        Modules/KategoriLayanan/Providers/KategoriLayananServiceProvider.php
 * @description Bootstrap modul KategoriLayanan. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) -- KategoriLayananService type-hint langsung
 *              ke KategoriLayananRepository konkret, Laravel container resolve
 *              otomatis. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\KategoriLayanan\Providers;

use Modules\BaseServiceProvider;

final class KategoriLayananServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
