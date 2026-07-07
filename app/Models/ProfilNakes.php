<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Model
 * @file        ProfilNakes.php
 * @path        app/Models/ProfilNakes.php
 * @description Model profil tenaga kesehatan — menghubungkan User dengan
 *              Profesi, Poliklinik (opsional), dan nomor SIP/STR.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

use Database\Factories\ProfilNakesFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['user_id', 'profesi_id', 'poliklinik_id', 'no_sip', 'no_str', 'str_berlaku_sampai'])]
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profesi(): BelongsTo
    {
        return $this->belongsTo(Profesi::class);
    }

    public function poliklinik(): BelongsTo
    {
        return $this->belongsTo(Poliklinik::class);
    }
}
