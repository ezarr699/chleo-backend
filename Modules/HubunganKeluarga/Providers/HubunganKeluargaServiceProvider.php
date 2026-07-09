<?php
/**
 * ============================================================
 * @module      HubunganKeluarga
 * @layer       Provider
 * @file        HubunganKeluargaServiceProvider.php
 * @path        Modules/HubunganKeluarga/Providers/HubunganKeluargaServiceProvider.php
 * @description Bootstrap modul HubunganKeluarga. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) -- HubunganKeluargaService type-hint langsung
 *              ke HubunganKeluargaRepository konkret, Laravel container resolve
 *              otomatis. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\HubunganKeluarga\Providers;

use Modules\BaseServiceProvider;

final class HubunganKeluargaServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
