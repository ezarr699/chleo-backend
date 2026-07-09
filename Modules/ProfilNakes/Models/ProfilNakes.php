<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Model
 * @file        ProfilNakes.php
 * @path        Modules/ProfilNakes/Models/ProfilNakes.php
 * @description Model profil tenaga kesehatan — menghubungkan User dengan
 *              Profesi, Poliklinik (opsional), dan nomor SIP/STR.
 *              kode_bpjs = kode dokter versi BPJS, dipakai saat bridging
 *              Antrean (field `kodedokter`). user_id/profesi_id/
 *              poliklinik_id SENGAJA kolom polos tanpa relasi belongsTo
 *              (dulu ke User/Profesi/Poliklinik milik modul lain —
 *              dilarang Hukum Isolasi Total Eloquent). Nama tampilannya
 *              diresolusi ProfilNakesService lewat
 *              Repositories/ProfilNakesMasterDataCacheRepository.php
 *              (Profesi/Poliklinik) dan
 *              Repositories/ProfilNakesUserCacheRepository.php (User).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\ProfilNakes\Models;

use Database\Factories\ProfilNakesFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['user_id', 'profesi_id', 'poliklinik_id', 'no_sip', 'no_str', 'str_berlaku_sampai', 'kode_bpjs'])]
class ProfilNakes extends Model
{
    /** @use HasFactory<ProfilNakesFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'profil_nakes';

    protected function casts(): array
    {
        return [
            'str_berlaku_sampai' => 'date',
        ];
    }

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find ProfilNakesFactory once the model moves to
     * Modules\ProfilNakes\Models, so the mapping has to be explicit here
     * instead of relying on convention.
     */
    protected static function newFactory(): ProfilNakesFactory
    {
        return ProfilNakesFactory::new();
    }
}
