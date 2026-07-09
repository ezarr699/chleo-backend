<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Provider
 * @file        RegistrasiServiceProvider.php
 * @path        Modules/Registrasi/Providers/RegistrasiServiceProvider.php
 * @description Bootstrap modul Registrasi. Tidak ada binding interface->
 *              implementasi lagi untuk RegistrasiRepository (Contracts/
 *              dihapus) — RegistrasiService type-hint langsung ke
 *              RegistrasiRepository konkret. Binding
 *              Shared\Contracts\KunjunganStatusInterface supaya modul
 *              lain (RawatJalan) bisa baca status Kunjungan terkini tanpa
 *              mengimpor Model Kunjungan. Mendaftarkan
 *              SyncCrossModuleDataToRegistrasi sebagai listener EMPAT
 *              Global Event (MasterDataCreatedOrUpdated,
 *              ProfilNakesCreatedOrUpdated, UserCreatedOrUpdated,
 *              PasienCreatedOrUpdated) — modul-modul itu tidak perlu tahu
 *              apa-apa soal keberadaan modul ini. parent::boot()
 *              (Modules/BaseServiceProvider.php) mengotomasi load
 *              Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Providers;

use App\Events\MasterDataCreatedOrUpdated;
use App\Events\PasienCreatedOrUpdated;
use App\Events\ProfilNakesCreatedOrUpdated;
use App\Events\UserCreatedOrUpdated;
use Illuminate\Support\Facades\Event;
use Modules\BaseServiceProvider;
use Modules\Registrasi\Listeners\SyncCrossModuleDataToRegistrasi;
use Modules\Registrasi\Services\KunjunganStatusLookupService;
use Modules\Shared\Contracts\KunjunganStatusInterface;

final class RegistrasiServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->app->bind(KunjunganStatusInterface::class, KunjunganStatusLookupService::class);
    }

    public function boot(): void
    {
        parent::boot();

        Event::listen(MasterDataCreatedOrUpdated::class, [SyncCrossModuleDataToRegistrasi::class, 'handleMasterData']);
        Event::listen(ProfilNakesCreatedOrUpdated::class, [SyncCrossModuleDataToRegistrasi::class, 'handleProfilNakes']);
        Event::listen(UserCreatedOrUpdated::class, [SyncCrossModuleDataToRegistrasi::class, 'handleUser']);
        Event::listen(PasienCreatedOrUpdated::class, [SyncCrossModuleDataToRegistrasi::class, 'handlePasien']);
    }
}
