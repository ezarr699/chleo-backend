<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Provider
 * @file        PenjaminServiceProvider.php
 * @path        Modules/Penjamin/Providers/PenjaminServiceProvider.php
 * @description Bootstrap modul Penjamin. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) -- PenjaminService type-hint langsung
 *              ke PenjaminRepository konkret, Laravel container resolve
 *              otomatis. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Penjamin\Providers;

use Modules\BaseServiceProvider;

final class PenjaminServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
