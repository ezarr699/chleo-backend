<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Model
 * @file        RegistrasiMasterDataCache.php
 * @path        Modules/Registrasi/Models/RegistrasiMasterDataCache.php
 * @description Replika lokal generik (id + nama) dari data lintas modul
 *              yang dibutuhkan Registrasi untuk ditampilkan di Kunjungan:
 *              Poliklinik, Penjamin (dari MasterDataCreatedOrUpdated),
 *              ProfilNakes (dari ProfilNakesCreatedOrUpdated), dan User
 *              (dari UserCreatedOrUpdated, untuk registered_by) — semua
 *              dibedakan lewat kolom `modul`. Lihat
 *              Listeners/SyncCrossModuleDataToRegistrasi.php.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Models;

use Illuminate\Database\Eloquent\Model;

final class RegistrasiMasterDataCache extends Model
{
    protected $table = 'registrasi_master_data_cache';

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
