<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Model
 * @file        Satuan.php
 * @path        Modules/Satuan/Models/Satuan.php
 * @description Model data master Satuan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\Satuan\Models;

use Database\Factories\SatuanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class Satuan extends Model
{
    /** @use HasFactory<SatuanFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'satuan';

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find SatuanFactory once the model moves to Modules\Satuan\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): SatuanFactory
    {
        return SatuanFactory::new();
    }
}
