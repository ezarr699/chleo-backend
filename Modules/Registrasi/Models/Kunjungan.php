<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Model
 * @file        Kunjungan.php
 * @path        Modules/Registrasi/Models/Kunjungan.php
 * @description Model Kunjungan — 1 baris per kedatangan pasien (bukan
 *              per orang, itu tugas Pasien). no_antrian_bpjs,
 *              no_kunjungan_bpjs, dan no_sep sengaja nullable, diisi
 *              belakangan oleh proses bridging BPJS (domain JKN/INT),
 *              bukan oleh modul ini. pasien_id/poliklinik_id/
 *              profil_nakes_id/penjamin_id/registered_by SENGAJA kolom
 *              polos tanpa relasi belongsTo (dulu ke Pasien/Poliklinik/
 *              ProfilNakes/Penjamin/User milik modul lain — dilarang
 *              Hukum Isolasi Total Eloquent). pemeriksaan() hasOne ke
 *              Pemeriksaan (Modul RawatJalan) juga dihapus dengan alasan
 *              sama — RawatJalanRepository sudah query Pemeriksaan
 *              langsung by kunjungan_id, tidak pernah lewat relasi ini.
 *              Nama tampilan diresolusi RegistrasiService lewat
 *              Repositories/RegistrasiMasterDataCacheRepository.php +
 *              RegistrasiPasienCacheRepository.php.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\Registrasi\Models;

use Database\Factories\KunjunganFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'pasien_id', 'poliklinik_id', 'profil_nakes_id', 'penjamin_id',
    'cara_masuk', 'sumber_booking', 'tanggal_kunjungan', 'jam_praktek',
    'urutan_harian', 'no_registrasi', 'angka_antrian', 'no_antrian',
    'no_antrian_bpjs', 'no_kunjungan_bpjs', 'no_sep',
    'status', 'alasan_batal', 'catatan', 'registered_by',
])]
class Kunjungan extends Model
{
    /** @use HasFactory<KunjunganFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'kunjungan';

    protected function casts(): array
    {
        return [
            'tanggal_kunjungan' => 'date',
        ];
    }

    /** @return HasMany<KunjunganRujukan, $this> */
    public function rujukan(): HasMany
    {
        return $this->hasMany(KunjunganRujukan::class);
    }

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find KunjunganFactory once the model moves to Modules\Registrasi\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): KunjunganFactory
    {
        return KunjunganFactory::new();
    }
}
