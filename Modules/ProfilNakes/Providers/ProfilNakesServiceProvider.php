<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Provider
 * @file        ProfilNakesServiceProvider.php
 * @path        Modules/ProfilNakes/Providers/ProfilNakesServiceProvider.php
 * @description Bootstrap modul ProfilNakes. Tidak ada binding interface->
 *              implementasi lagi (Contracts/ dihapus) — ProfilNakesService
 *              type-hint langsung ke ProfilNakesRepository konkret. Binding
 *              Shared\Contracts\ProfilNakesLookupInterface supaya modul
 *              lain (Registrasi) bisa validasi penugasan nakes-poliklinik
 *              tanpa mengimpor Model ProfilNakes. Mendaftarkan
 *              SyncCrossModuleDataToProfilNakes sebagai listener DUA
 *              Global Event (MasterDataCreatedOrUpdated,
 *              UserCreatedOrUpdated) — modul Profesi/Poliklinik/Auth
 *              tidak perlu tahu apa-apa soal keberadaan modul ini.
 *              parent::boot() (Modules/BaseServiceProvider.php) mengotomasi
 *              load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\ProfilNakes\Providers;

use App\Events\MasterDataCreatedOrUpdated;
use App\Events\UserCreatedOrUpdated;
use Illuminate\Support\Facades\Event;
use Modules\BaseServiceProvider;
use Modules\ProfilNakes\Listeners\SyncCrossModuleDataToProfilNakes;
use Modules\ProfilNakes\Services\ProfilNakesLookupService;
use Modules\Shared\Contracts\ProfilNakesLookupInterface;

final class ProfilNakesServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProfilNakesLookupInterface::class, ProfilNakesLookupService::class);
    }

    public function boot(): void
    {
        parent::boot();

        Event::listen(MasterDataCreatedOrUpdated::class, [SyncCrossModuleDataToProfilNakes::class, 'handleMasterData']);
        Event::listen(UserCreatedOrUpdated::class, [SyncCrossModuleDataToProfilNakes::class, 'handleUser']);
    }
}
