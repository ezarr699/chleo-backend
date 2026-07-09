<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Provider
 * @file        AgamaServiceProvider.php
 * @path        Modules/Agama/Providers/AgamaServiceProvider.php
 * @description Bootstrap modul Agama. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) — AgamaService type-hint langsung
 *              ke AgamaRepository konkret, Laravel container resolve
 *              otomatis. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Agama\Providers;

use Modules\BaseServiceProvider;

final class AgamaServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
