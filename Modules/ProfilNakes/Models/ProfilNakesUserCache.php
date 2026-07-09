<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Model
 * @file        ProfilNakesUserCache.php
 * @path        Modules/ProfilNakes/Models/ProfilNakesUserCache.php
 * @description Replika lokal data User (id, nama, email) yang dibutuhkan
 *              ProfilNakes untuk ditampilkan — tabel terpisah dari
 *              ProfilNakesMasterDataCache karena User membawa field email
 *              yang tidak ada di data master generik (lihat
 *              app/Events/UserCreatedOrUpdated.php).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\ProfilNakes\Models;

use Illuminate\Database\Eloquent\Model;

final class ProfilNakesUserCache extends Model
{
    protected $table = 'profil_nakes_user_cache';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'synced_at',
    ];

    protected function casts(): array
    {
        return [
            'synced_at' => 'datetime',
        ];
    }
}
