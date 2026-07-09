<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Provider
 * @file        PekerjaanServiceProvider.php
 * @path        Modules/Pekerjaan/Providers/PekerjaanServiceProvider.php
 * @description Bootstrap modul Pekerjaan. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) -- PekerjaanService type-hint langsung
 *              ke PekerjaanRepository konkret, Laravel container resolve
 *              otomatis. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pekerjaan\Providers;

use Modules\BaseServiceProvider;

final class PekerjaanServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
