<?php
/**
 * ============================================================
 * @module      Jkn
 * @layer       Provider
 * @file        JknServiceProvider.php
 * @path        Modules/Jkn/Providers/JknServiceProvider.php
 * @description Bootstrap modul Jkn. Tidak ada binding interface->implementasi
 *              (Contracts/ dihapus) — VClaimController type-hint langsung
 *              ke VClaimService konkret, Laravel container resolve
 *              otomatis. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Jkn\Providers;

use Modules\BaseServiceProvider;

final class JknServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
