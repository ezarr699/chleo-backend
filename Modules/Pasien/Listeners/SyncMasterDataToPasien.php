<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Listener
 * @file        SyncMasterDataToPasien.php
 * @path        Modules/Pasien/Listeners/SyncMasterDataToPasien.php
 * @description Penguping Global Event App\Events\MasterDataCreatedOrUpdated
 *              (dipicu semua modul data master, lihat
 *              app/Support/MasterData/AbstractMasterDataService.php).
 *              Pasien hanya peduli pada JenisKelamin, GolonganDarah, dan
 *              Asuransi — event dari modul lain (Agama, Satuan, dst)
 *              diabaikan. Tidak pernah menyentuh Model JenisKelamin/
 *              GolonganDarah/Asuransi — hanya membaca field primitif yang
 *              sudah disiapkan event itu sendiri.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pasien\Listeners;

use App\Events\MasterDataCreatedOrUpdated;
use Modules\Pasien\Repositories\PasienMasterDataCacheRepository;

final class SyncMasterDataToPasien
{
    /** @var array<int, string> */
    private const MODUL_RELEVAN = ['JenisKelamin', 'GolonganDarah', 'Asuransi'];

    public function __construct(
        private readonly PasienMasterDataCacheRepository $cacheRepository,
    ) {}

    public function handle(MasterDataCreatedOrUpdated $event): void
    {
        if (! in_array($event->modul, self::MODUL_RELEVAN, true)) {
            return;
        }

        $this->cacheRepository->upsert($event->modul, $event->id, $event->nama);
    }
}
