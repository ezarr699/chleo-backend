<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Model
 * @file        Asuransi.php
 * @path        Modules/Asuransi/Models/Asuransi.php
 * @description Model data master Asuransi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\Asuransi\Models;

use Database\Factories\AsuransiFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class Asuransi extends Model
{
    /** @use HasFactory<AsuransiFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'asuransi';

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find AsuransiFactory once the model moves to Modules\Asuransi\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): AsuransiFactory
    {
        return AsuransiFactory::new();
    }
}
