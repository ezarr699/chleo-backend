<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Model
 * @file        PasienAsuransi.php
 * @path        app/Models/PasienAsuransi.php
 * @description Model entri asuransi tambahan milik pasien. Satu pasien
 *              bisa punya banyak baris (lihat Pasien::asuransiList()).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['pasien_id', 'asuransi_id', 'nomor_polis', 'masa_berlaku'])]
class PasienAsuransi extends Model
{
    protected $table = 'pasien_asuransi';

    protected function casts(): array
    {
        return [
            'masa_berlaku' => 'date',
        ];
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function asuransi()
    {
        return $this->belongsTo(Asuransi::class);
    }
}
