<?php
/**
 * ============================================================
 * @module      Billing
 * @layer       Listener
 * @file        SyncPasienToBilling.php
 * @path        Modules/Billing/Listeners/SyncPasienToBilling.php
 * @description Penguping Global Event App\Events\PasienCreatedOrUpdated.
 *              Setiap kali Modul Pasien membuat/memperbarui pasien,
 *              listener ini menyalin data primitif (pasien_id, nama,
 *              no_rm) dari payload event ke tabel replika lokal
 *              billing_pasien_cache. Tidak pernah menyentuh
 *              App\Models\Pasien — hanya membaca field yang sudah
 *              disiapkan sebagai array primitif oleh event itu sendiri.
 *              Didaftarkan di Providers/BillingServiceProvider.php.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Billing\Listeners;

use App\Events\PasienCreatedOrUpdated;
use Modules\Billing\Repositories\BillingPasienCacheRepository;

final class SyncPasienToBilling
{
    public function __construct(
        private readonly BillingPasienCacheRepository $pasienCacheRepository,
    ) {}

    public function handle(PasienCreatedOrUpdated $event): void
    {
        $this->pasienCacheRepository->upsert($event->pasienId, [
            'nama_lengkap' => $event->nama,
            'no_rm' => $event->noRm,
        ]);
    }
}
