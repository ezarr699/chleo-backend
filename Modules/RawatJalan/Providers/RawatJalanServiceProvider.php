<?php
/**
 * ============================================================
 * @module      RawatJalan
 * @layer       Provider
 * @file        RawatJalanServiceProvider.php
 * @path        Modules/RawatJalan/Providers/RawatJalanServiceProvider.php
 * @description Bootstrap modul RawatJalan. Tidak ada binding interface->
 *              implementasi lagi (Contracts/ dihapus) — RawatJalanService/
 *              RawatJalanRepository type-hint langsung ke class konkret
 *              serta dua Shared\Contracts (Icd10LookupInterface,
 *              ProfilNakesLookupInterface, KunjunganStatusInterface)
 *              untuk data lintas modul. parent::boot()
 *              (Modules/BaseServiceProvider.php) mengotomasi load
 *              Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\RawatJalan\Providers;

use Modules\BaseServiceProvider;

final class RawatJalanServiceProvider extends BaseServiceProvider
{
    public function register(): void {}
}
