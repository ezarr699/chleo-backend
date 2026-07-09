<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Listener
 * @file        SyncCrossModuleDataToProfilNakes.php
 * @path        Modules/ProfilNakes/Listeners/SyncCrossModuleDataToProfilNakes.php
 * @description Penguping DUA Global Event sekaligus:
 *              MasterDataCreatedOrUpdated (filter modul Profesi/Poliklinik
 *              -> profil_nakes_master_data_cache) dan UserCreatedOrUpdated
 *              (-> profil_nakes_user_cache). Tidak pernah menyentuh Model
 *              User/Profesi/Poliklinik — hanya membaca field primitif dari
 *              payload event.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\ProfilNakes\Listeners;

use App\Events\MasterDataCreatedOrUpdated;
use App\Events\UserCreatedOrUpdated;
use Modules\ProfilNakes\Repositories\ProfilNakesMasterDataCacheRepository;
use Modules\ProfilNakes\Repositories\ProfilNakesUserCacheRepository;

final class SyncCrossModuleDataToProfilNakes
{
    /** @var array<int, string> */
    private const MODUL_RELEVAN = ['Profesi', 'Poliklinik'];

    public function __construct(
        private readonly ProfilNakesMasterDataCacheRepository $masterDataCacheRepository,
        private readonly ProfilNakesUserCacheRepository $userCacheRepository,
    ) {}

    public function handleMasterData(MasterDataCreatedOrUpdated $event): void
    {
        if (! in_array($event->modul, self::MODUL_RELEVAN, true)) {
            return;
        }

        $this->masterDataCacheRepository->upsert($event->modul, $event->id, $event->nama);
    }

    public function handleUser(UserCreatedOrUpdated $event): void
    {
        $this->userCacheRepository->upsert($event->id, $event->name, $event->email);
    }
}
