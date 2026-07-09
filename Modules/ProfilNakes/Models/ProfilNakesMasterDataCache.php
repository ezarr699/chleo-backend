<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Model
 * @file        ProfilNakesMasterDataCache.php
 * @path        Modules/ProfilNakes/Models/ProfilNakesMasterDataCache.php
 * @description Replika lokal generik (id + name) dari data master lintas
 *              modul yang dibutuhkan ProfilNakes untuk ditampilkan
 *              (Profesi, Poliklinik) — lihat
 *              Listeners/SyncCrossModuleDataToProfilNakes.php. Sama
 *              persis polanya dengan Modules/Pasien/Models/PasienMasterDataCache.php.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\ProfilNakes\Models;

use Illuminate\Database\Eloquent\Model;

final class ProfilNakesMasterDataCache extends Model
{
    protected $table = 'profil_nakes_master_data_cache';

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
