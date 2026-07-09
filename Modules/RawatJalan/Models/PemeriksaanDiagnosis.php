<?php
/**
 * ============================================================
 * @module      RawatJalan
 * @layer       Model
 * @file        PemeriksaanDiagnosis.php
 * @path        Modules/RawatJalan/Models/PemeriksaanDiagnosis.php
 * @description Model PemeriksaanDiagnosis — diagnosis ICD-10 (Assessment,
 *              RWJ-01-1) yang menempel ke satu Pemeriksaan. tipe:
 *              'utama' | 'sekunder'. icd10_id SENGAJA kolom polos tanpa
 *              relasi belongsTo (dulu ke Icd10 milik modul lain —
 *              dilarang Hukum Isolasi Total Eloquent). icd10_kode_snapshot
 *              & icd10_deskripsi_snapshot adalah SALINAN TEKS (Hukum
 *              Snapshot Data) diambil dari Icd10LookupInterface::detail()
 *              pada saat diagnosis dicatat — rekam medis tidak boleh
 *              berubah walau katalog ICD-10 dikoreksi belakangan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\RawatJalan\Models;

use Database\Factories\PemeriksaanDiagnosisFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['pemeriksaan_id', 'icd10_id', 'icd10_kode_snapshot', 'icd10_deskripsi_snapshot', 'tipe', 'catatan'])]
class PemeriksaanDiagnosis extends Model
{
    /** @use HasFactory<PemeriksaanDiagnosisFactory> */
    use HasFactory;

    protected $table = 'pemeriksaan_diagnosis';

    public function pemeriksaan(): BelongsTo
    {
        return $this->belongsTo(Pemeriksaan::class);
    }

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find PemeriksaanDiagnosisFactory once the model moves to
     * Modules\RawatJalan\Models, so the mapping has to be explicit here
     * instead of relying on convention.
     */
    protected static function newFactory(): PemeriksaanDiagnosisFactory
    {
        return PemeriksaanDiagnosisFactory::new();
    }
}
