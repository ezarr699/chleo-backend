<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Model
 * @file        KunjunganRujukan.php
 * @path        Modules/Registrasi/Models/KunjunganRujukan.php
 * @description Model KunjunganRujukan (REG-01-2) — catatan rujukan
 *              masuk (pasien datang dari faskes lain) atau keluar
 *              (pasien dirujuk ke faskes lain) yang menempel ke satu
 *              Kunjungan. nomor_rujukan_sisrute/nomor_rujukan_bpjs
 *              nullable, diisi belakangan oleh bridging SISRUTE/BPJS.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\Registrasi\Models;

use Database\Factories\KunjunganRujukanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'kunjungan_id', 'arah',
    'asal_faskes_kode', 'asal_faskes_nama',
    'tujuan_faskes_kode', 'tujuan_faskes_nama',
    'nomor_rujukan_sisrute', 'nomor_rujukan_bpjs',
    'diagnosa_rujukan', 'catatan_rujukan', 'tanggal_rujukan',
])]
class KunjunganRujukan extends Model
{
    /** @use HasFactory<KunjunganRujukanFactory> */
    use HasFactory;

    protected $table = 'kunjungan_rujukan';

    protected function casts(): array
    {
        return [
            'tanggal_rujukan' => 'date',
        ];
    }

    public function kunjungan(): BelongsTo
    {
        return $this->belongsTo(Kunjungan::class);
    }

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find KunjunganRujukanFactory once the model moves to
     * Modules\Registrasi\Models, so the mapping has to be explicit here
     * instead of relying on convention.
     */
    protected static function newFactory(): KunjunganRujukanFactory
    {
        return KunjunganRujukanFactory::new();
    }
}
