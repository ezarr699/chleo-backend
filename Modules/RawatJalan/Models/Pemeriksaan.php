<?php
/**
 * ============================================================
 * @module      RawatJalan
 * @layer       Model
 * @file        Pemeriksaan.php
 * @path        Modules/RawatJalan/Models/Pemeriksaan.php
 * @description Model Pemeriksaan (RWJ-01-1) — form SOAP satu episode
 *              rawat jalan, 1:1 ke Kunjungan. Assessment (diagnosis) ada
 *              di relasi diagnosis(), bukan kolom langsung. kunjungan_id
 *              SENGAJA kolom polos tanpa relasi belongsTo (dulu ke
 *              Kunjungan milik Modul Registrasi — dilarang Hukum Isolasi
 *              Total Eloquent; RawatJalanRepository sudah query langsung
 *              by kunjungan_id, tidak pernah lewat relasi). nama_nakes_snapshot
 *              adalah SALINAN TEKS (Hukum Snapshot Data — rekam medis
 *              eksplisit disebut sebagai contoh data yang wajib snapshot)
 *              diambil dari ProfilNakesLookupInterface::namaLengkap()
 *              pada saat pemeriksaan dicatat, BUKAN relasi dinamis —
 *              siapa yang memeriksa tidak boleh "berubah" di rekam medis
 *              lama walau data ProfilNakes diedit belakangan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\RawatJalan\Models;

use Database\Factories\PemeriksaanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'kunjungan_id', 'profil_nakes_id', 'nama_nakes_snapshot', 'subjektif',
    'tekanan_darah_sistolik', 'tekanan_darah_diastolik', 'nadi', 'suhu',
    'pernapasan', 'saturasi_oksigen', 'tinggi_badan', 'berat_badan', 'objektif_lainnya',
    'rencana', 'diperiksa_pada',
])]
class Pemeriksaan extends Model
{
    /** @use HasFactory<PemeriksaanFactory> */
    use HasFactory;

    protected $table = 'pemeriksaan';

    protected function casts(): array
    {
        return [
            'diperiksa_pada' => 'datetime',
            'suhu' => 'decimal:1',
            'tinggi_badan' => 'decimal:1',
            'berat_badan' => 'decimal:1',
        ];
    }

    /** @return HasMany<PemeriksaanDiagnosis, $this> */
    public function diagnosis(): HasMany
    {
        return $this->hasMany(PemeriksaanDiagnosis::class);
    }

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find PemeriksaanFactory once the model moves to
     * Modules\RawatJalan\Models, so the mapping has to be explicit here
     * instead of relying on convention.
     */
    protected static function newFactory(): PemeriksaanFactory
    {
        return PemeriksaanFactory::new();
    }
}
