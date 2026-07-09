<?php
/**
 * ============================================================
 * @module      GolonganDarah
 * @layer       Model
 * @file        GolonganDarah.php
 * @path        Modules/GolonganDarah/Models/GolonganDarah.php
 * @description Model data master Golongan Darah.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\GolonganDarah\Models;

use Database\Factories\GolonganDarahFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class GolonganDarah extends Model
{
    /** @use HasFactory<GolonganDarahFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'golongan_darah';

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find GolonganDarahFactory once the model moves to Modules\GolonganDarah\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): GolonganDarahFactory
    {
        return GolonganDarahFactory::new();
    }
}
