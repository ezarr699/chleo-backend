<?php
/**
 * ============================================================
 * @module      KategoriObat
 * @layer       Provider
 * @file        KategoriObatServiceProvider.php
 * @path        Modules/KategoriObat/Providers/KategoriObatServiceProvider.php
 * @description Bootstrap modul KategoriObat. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) -- KategoriObatService type-hint langsung
 *              ke KategoriObatRepository konkret, Laravel container resolve
 *              otomatis. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\KategoriObat\Providers;

use Modules\BaseServiceProvider;

final class KategoriObatServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
