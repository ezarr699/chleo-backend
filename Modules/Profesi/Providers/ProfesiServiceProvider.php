<?php
/**
 * ============================================================
 * @module      Profesi
 * @layer       Provider
 * @file        ProfesiServiceProvider.php
 * @path        Modules/Profesi/Providers/ProfesiServiceProvider.php
 * @description Bootstrap modul Profesi. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) -- ProfesiService type-hint langsung
 *              ke ProfesiRepository konkret, Laravel container resolve
 *              otomatis. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Profesi\Providers;

use Modules\BaseServiceProvider;

final class ProfesiServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
