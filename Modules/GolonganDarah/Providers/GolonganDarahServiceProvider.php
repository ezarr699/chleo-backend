<?php
/**
 * ============================================================
 * @module      GolonganDarah
 * @layer       Provider
 * @file        GolonganDarahServiceProvider.php
 * @path        Modules/GolonganDarah/Providers/GolonganDarahServiceProvider.php
 * @description Bootstrap modul GolonganDarah. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) -- GolonganDarahService type-hint langsung
 *              ke GolonganDarahRepository konkret, Laravel container resolve
 *              otomatis. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\GolonganDarah\Providers;

use Modules\BaseServiceProvider;

final class GolonganDarahServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
