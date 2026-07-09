<?php
/**
 * ============================================================
 * @module      Icd10
 * @layer       Provider
 * @file        Icd10ServiceProvider.php
 * @path        Modules/Icd10/Providers/Icd10ServiceProvider.php
 * @description Bootstrap modul Icd10. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) — Icd10Service type-hint langsung
 *              ke Icd10Repository konkret. Binding
 *              Shared\Contracts\Icd10LookupInterface supaya modul lain
 *              (RawatJalan) bisa snapshot kode+deskripsi ICD-10 tanpa
 *              mengimpor Model Icd10. parent::boot()
 *              (Modules/BaseServiceProvider.php) mengotomasi load
 *              Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Icd10\Providers;

use Modules\BaseServiceProvider;
use Modules\Icd10\Services\Icd10LookupService;
use Modules\Shared\Contracts\Icd10LookupInterface;

final class Icd10ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Icd10LookupInterface::class, Icd10LookupService::class);
    }
}
