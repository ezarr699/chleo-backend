<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Provider
 * @file        PoliklinikServiceProvider.php
 * @path        Modules/Poliklinik/Providers/PoliklinikServiceProvider.php
 * @description Bootstrap modul Poliklinik. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) -- PoliklinikService type-hint langsung
 *              ke PoliklinikRepository konkret, Laravel container resolve
 *              otomatis. Binding Shared\Contracts\PoliklinikLookupInterface
 *              supaya modul lain (Registrasi) bisa hitung prefix antrian
 *              tanpa mengimpor Model Poliklinik. parent::boot()
 *              (Modules/BaseServiceProvider.php) mengotomasi load
 *              Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Poliklinik\Providers;

use Modules\BaseServiceProvider;
use Modules\Poliklinik\Services\PoliklinikLookupService;
use Modules\Shared\Contracts\PoliklinikLookupInterface;

final class PoliklinikServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PoliklinikLookupInterface::class, PoliklinikLookupService::class);
    }
}
