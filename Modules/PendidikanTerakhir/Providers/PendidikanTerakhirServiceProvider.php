<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Provider
 * @file        PendidikanTerakhirServiceProvider.php
 * @path        Modules/PendidikanTerakhir/Providers/PendidikanTerakhirServiceProvider.php
 * @description Bootstrap modul PendidikanTerakhir. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) -- PendidikanTerakhirService type-hint langsung
 *              ke PendidikanTerakhirRepository konkret, Laravel container resolve
 *              otomatis. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\PendidikanTerakhir\Providers;

use Modules\BaseServiceProvider;

final class PendidikanTerakhirServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
