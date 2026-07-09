<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Model
 * @file        PasienMasterDataCache.php
 * @path        Modules/Pasien/Models/PasienMasterDataCache.php
 * @description Replika lokal (bukan relasi Eloquent) dari data master
 *              lintas modul yang dibutuhkan Pasien untuk ditampilkan
 *              (saat ini: JenisKelamin, GolonganDarah, Asuransi — lihat
 *              Listeners/SyncMasterDataToPasien.php). Satu tabel generik
 *              dibedakan lewat kolom `modul`, bukan satu tabel per modul
 *              sumber — bentuk datanya identik (id + name) untuk semua
 *              data master, jadi satu tabel cukup dan lebih mudah dirawat
 *              daripada menduplikasi migrasi/model untuk tiap sumber.
 *              Modul ini TIDAK PERNAH meng-import Model JenisKelamin/
 *              GolonganDarah/Asuransi milik modul lain.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pasien\Models;

use Illuminate\Database\Eloquent\Model;

final class PasienMasterDataCache extends Model
{
    protected $table = 'pasien_master_data_cache';

    protected $fillable = [
        'modul',
        'ref_id',
        'nama',
        'synced_at',
    ];

    protected function casts(): array
    {
        return [
            'synced_at' => 'datetime',
        ];
    }
}
