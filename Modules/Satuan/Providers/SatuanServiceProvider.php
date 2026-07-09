<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Provider
 * @file        SatuanServiceProvider.php
 * @path        Modules/Satuan/Providers/SatuanServiceProvider.php
 * @description Bootstrap modul Satuan. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) -- SatuanService type-hint langsung
 *              ke SatuanRepository konkret, Laravel container resolve
 *              otomatis. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Satuan\Providers;

use Modules\BaseServiceProvider;

final class SatuanServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
