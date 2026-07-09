<?php
/**
 * ============================================================
 * @module      KategoriObat
 * @layer       Model
 * @file        KategoriObat.php
 * @path        Modules/KategoriObat/Models/KategoriObat.php
 * @description Model data master Kategori Obat.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\KategoriObat\Models;

use Database\Factories\KategoriObatFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class KategoriObat extends Model
{
    /** @use HasFactory<KategoriObatFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'kategori_obat';

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find KategoriObatFactory once the model moves to Modules\KategoriObat\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): KategoriObatFactory
    {
        return KategoriObatFactory::new();
    }
}
