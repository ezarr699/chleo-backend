<?php
/**
 * ============================================================
 * @module      Billing
 * @layer       Repository
 * @file        BillingPasienCacheRepository.php
 * @path        Modules/Billing/Repositories/BillingPasienCacheRepository.php
 * @description Gerbang query satu-satunya ke tabel billing_pasien_cache.
 *              upsert() dipanggil oleh Listeners/SyncPasienToBilling.php
 *              setiap kali Global Event PasienCreatedOrUpdated diterima.
 *              findByPasienId() dipakai BillingService untuk mengambil
 *              snapshot nama/no_rm saat invoice dibuat.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Billing\Repositories;

use Modules\Billing\Models\BillingPasienCache;

final class BillingPasienCacheRepository
{
    public function findByPasienId(int $pasienId): ?BillingPasienCache
    {
        return BillingPasienCache::query()
            ->where('pasien_id', $pasienId)
            ->first();
    }

    /** @param array{nama_lengkap: string, no_rm: ?string} $data */
    public function upsert(int $pasienId, array $data): BillingPasienCache
    {
        return BillingPasienCache::query()->updateOrCreate(
            ['pasien_id' => $pasienId],
            [...$data, 'synced_at' => now()],
        );
    }
}
