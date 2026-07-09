<?php
/**
 * ============================================================
 * @module      KategoriTriase
 * @layer       Model
 * @file        KategoriTriase.php
 * @path        Modules/KategoriTriase/Models/KategoriTriase.php
 * @description Model data master Kategori Triase.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\KategoriTriase\Models;

use Database\Factories\KategoriTriaseFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class KategoriTriase extends Model
{
    /** @use HasFactory<KategoriTriaseFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'kategori_triase';

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find KategoriTriaseFactory once the model moves to Modules\KategoriTriase\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): KategoriTriaseFactory
    {
        return KategoriTriaseFactory::new();
    }
}
