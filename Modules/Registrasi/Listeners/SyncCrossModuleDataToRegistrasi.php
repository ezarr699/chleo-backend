<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Listener
 * @file        SyncCrossModuleDataToRegistrasi.php
 * @path        Modules/Registrasi/Listeners/SyncCrossModuleDataToRegistrasi.php
 * @description Penguping EMPAT Global Event untuk menyinkronkan cache
 *              lokal Registrasi: MasterDataCreatedOrUpdated (filter modul
 *              Poliklinik/Penjamin), ProfilNakesCreatedOrUpdated,
 *              UserCreatedOrUpdated (semua tiga -> registrasi_master_data_cache),
 *              dan PasienCreatedOrUpdated (-> registrasi_pasien_cache).
 *              Tidak pernah menyentuh Model Poliklinik/Penjamin/ProfilNakes/
 *              User/Pasien — hanya membaca field primitif dari payload
 *              event.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Listeners;

use App\Events\MasterDataCreatedOrUpdated;
use App\Events\PasienCreatedOrUpdated;
use App\Events\ProfilNakesCreatedOrUpdated;
use App\Events\UserCreatedOrUpdated;
use Modules\Registrasi\Repositories\RegistrasiMasterDataCacheRepository;
use Modules\Registrasi\Repositories\RegistrasiPasienCacheRepository;

final class SyncCrossModuleDataToRegistrasi
{
    /** @var array<int, string> */
    private const MODUL_RELEVAN = ['Poliklinik', 'Penjamin'];

    public function __construct(
        private readonly RegistrasiMasterDataCacheRepository $masterDataCacheRepository,
        private readonly RegistrasiPasienCacheRepository $pasienCacheRepository,
    ) {}

    public function handleMasterData(MasterDataCreatedOrUpdated $event): void
    {
        if (! in_array($event->modul, self::MODUL_RELEVAN, true)) {
            return;
        }

        $this->masterDataCacheRepository->upsert($event->modul, $event->id, $event->nama);
    }

    public function handleProfilNakes(ProfilNakesCreatedOrUpdated $event): void
    {
        $this->masterDataCacheRepository->upsert('ProfilNakes', $event->id, $event->nama);
    }

    public function handleUser(UserCreatedOrUpdated $event): void
    {
        $this->masterDataCacheRepository->upsert('User', $event->id, $event->name);
    }

    public function handlePasien(PasienCreatedOrUpdated $event): void
    {
        $this->pasienCacheRepository->upsert($event->pasienId, $event->nik ?? '', $event->nama);
    }
}
