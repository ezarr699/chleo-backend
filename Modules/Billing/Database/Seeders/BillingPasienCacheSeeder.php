<?php
/**
 * ============================================================
 * @module      Billing
 * @layer       Database > Seeder (Tenant)
 * @file        BillingPasienCacheSeeder.php
 * @path        Modules/Billing/Database/Seeders/BillingPasienCacheSeeder.php
 * @description Data penyemai untuk pengujian Modul Billing SECARA
 *              TERISOLASI — tidak butuh Modul Pasien atau tabel pasien
 *              sungguhan berjalan sama sekali, cukup baris
 *              billing_pasien_cache dummy ini. Idempotent
 *              (updateOrCreate berdasarkan pasien_id) — aman dipanggil
 *              berulang. Bukan bagian dari DatabaseSeeder root secara
 *              otomatis; panggil eksplisit saat butuh data uji Billing.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Billing\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Billing\Models\BillingPasienCache;

final class BillingPasienCacheSeeder extends Seeder
{
    private const DUMMY_PASIEN = [
        ['pasien_id' => 1, 'nama_lengkap' => 'Budi Santoso', 'no_rm' => 'RM-0001'],
        ['pasien_id' => 2, 'nama_lengkap' => 'Siti Aminah', 'no_rm' => 'RM-0002'],
        ['pasien_id' => 3, 'nama_lengkap' => 'Ahmad Wijaya', 'no_rm' => null],
    ];

    public function run(): void
    {
        foreach (self::DUMMY_PASIEN as $row) {
            BillingPasienCache::query()->updateOrCreate(
                ['pasien_id' => $row['pasien_id']],
                [...$row, 'synced_at' => now()],
            );
        }
    }
}
