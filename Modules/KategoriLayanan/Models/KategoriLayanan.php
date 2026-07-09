<?php
/**
 * ============================================================
 * @module      KategoriLayanan
 * @layer       Model
 * @file        KategoriLayanan.php
 * @path        Modules/KategoriLayanan/Models/KategoriLayanan.php
 * @description Model data master Kategori Layanan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\KategoriLayanan\Models;

use Database\Factories\KategoriLayananFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class KategoriLayanan extends Model
{
    /** @use HasFactory<KategoriLayananFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'kategori_layanan';

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find KategoriLayananFactory once the model moves to Modules\KategoriLayanan\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): KategoriLayananFactory
    {
        return KategoriLayananFactory::new();
    }
}
