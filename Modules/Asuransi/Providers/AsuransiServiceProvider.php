<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Provider
 * @file        AsuransiServiceProvider.php
 * @path        Modules/Asuransi/Providers/AsuransiServiceProvider.php
 * @description Bootstrap modul Asuransi. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) -- AsuransiService type-hint langsung
 *              ke AsuransiRepository konkret, Laravel container resolve
 *              otomatis. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Asuransi\Providers;

use Modules\BaseServiceProvider;

final class AsuransiServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
