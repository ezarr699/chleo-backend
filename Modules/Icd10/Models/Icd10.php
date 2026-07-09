<?php
/**
 * ============================================================
 * @module      Icd10
 * @layer       Model
 * @file        Icd10.php
 * @path        Modules/Icd10/Models/Icd10.php
 * @description Model Icd10 (RWJ-01-1-1) — master data kode diagnosis
 *              WHO ICD-10. Diisi lewat Icd10Seeder (subset umum rawat
 *              jalan, bukan katalog WHO lengkap).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\Icd10\Models;

use Database\Factories\Icd10Factory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['kode', 'deskripsi', 'kategori'])]
class Icd10 extends Model
{
    /** @use HasFactory<Icd10Factory> */
    use HasFactory;

    protected $table = 'icd10';

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find Icd10Factory once the model moves to Modules\Icd10\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): Icd10Factory
    {
        return Icd10Factory::new();
    }
}
