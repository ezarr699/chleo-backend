<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Provider
 * @file        PasienServiceProvider.php
 * @path        Modules/Pasien/Providers/PasienServiceProvider.php
 * @description Bootstrap modul Pasien. Tidak ada binding interface->implementasi
 *              lagi (Contracts/ dihapus) — PasienService type-hint langsung
 *              ke PasienRepository konkret. Mendaftarkan
 *              SyncMasterDataToPasien sebagai listener Global Event
 *              MasterDataCreatedOrUpdated (Pasien = subscriber data
 *              JenisKelamin/GolonganDarah/Asuransi) — modul-modul itu
 *              tidak perlu tahu apa-apa soal keberadaan Modul Pasien.
 *              parent::boot() (Modules/BaseServiceProvider.php) mengotomasi
 *              load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pasien\Providers;

use App\Events\MasterDataCreatedOrUpdated;
use Illuminate\Support\Facades\Event;
use Modules\BaseServiceProvider;
use Modules\Pasien\Listeners\SyncMasterDataToPasien;

final class PasienServiceProvider extends BaseServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        parent::boot();

        Event::listen(MasterDataCreatedOrUpdated::class, SyncMasterDataToPasien::class);
    }
}
