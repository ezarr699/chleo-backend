<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Model
 * @file        Pasien.php
 * @path        Modules/Pasien/Models/Pasien.php
 * @description Model Pasien. Status workflow: belum_verifikasi -> aktif
 *              (otomatis setelah verifikasi) -> nonaktif (toggle manual).
 *              jenis_kelamin_id/golongan_darah_id/provinsi_code/
 *              kabupaten_code/kecamatan_code/kelurahan_code SENGAJA
 *              kolom polos tanpa relasi Eloquent (dulu belongsTo ke
 *              JenisKelamin/GolonganDarah/Provinsi/dst milik modul lain —
 *              dilarang Hukum Isolasi Total Eloquent). Nama tampilannya
 *              diresolusi PasienService lewat
 *              Repositories/PasienMasterDataCacheRepository.php (untuk
 *              jenis_kelamin/golongan_darah) dan
 *              Shared\Contracts\WilayahLookupInterface (untuk wilayah).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\Pasien\Models;

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

    /** Banyak entri asuransi tambahan — lihat PasienAsuransi (modul sendiri). */
    public function asuransiList()
    {
        return $this->hasMany(PasienAsuransi::class);
    }

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find PasienFactory once the model moves to Modules\Pasien\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): PasienFactory
    {
        return PasienFactory::new();
    }
}
