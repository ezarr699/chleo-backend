<?php
/**
 * ============================================================
 * @module      JenisKelamin
 * @layer       Provider
 * @file        JenisKelaminServiceProvider.php
 * @path        Modules/JenisKelamin/Providers/JenisKelaminServiceProvider.php
 * @description Bootstrap modul JenisKelamin. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) -- JenisKelaminService type-hint langsung
 *              ke JenisKelaminRepository konkret, Laravel container resolve
 *              otomatis. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\JenisKelamin\Providers;

use Modules\BaseServiceProvider;

final class JenisKelaminServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
