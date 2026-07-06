<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Model
 * @file        Pasien.php
 * @path        app/Models/Pasien.php
 * @description Model Pasien. Status workflow: belum_verifikasi -> aktif
 *              (otomatis setelah verifikasi) -> nonaktif (toggle manual).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

use Database\Factories\PasienFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'nik', 'nama', 'tanggal_lahir', 'jenis_kelamin_id', 'status',
    'foto_path', 'tempat_lahir', 'golongan_darah_id', 'nomor_telepon', 'alamat',
    'provinsi_code', 'kabupaten_code', 'kecamatan_code', 'kelurahan_code',
    'bpjs_nomor', 'bpjs_jenis_peserta', 'bpjs_kelas', 'bpjs_nama_fasyankes', 'bpjs_kode_fasyankes', 'bpjs_masa_berlaku',
    'verified_at',
])]
class Pasien extends Model
{
    /** @use HasFactory<PasienFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'pasien';

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'bpjs_masa_berlaku' => 'date',
            'verified_at' => 'datetime',
        ];
    }

    public function jenisKelamin()
    {
        return $this->belongsTo(JenisKelamin::class);
    }

    public function golonganDarah()
    {
        return $this->belongsTo(GolonganDarah::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_code', 'code');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_code', 'code');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_code', 'code');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_code', 'code');
    }

    /** Banyak entri asuransi tambahan — lihat PasienAsuransi. */
    public function asuransiList()
    {
        return $this->hasMany(PasienAsuransi::class);
    }
}
