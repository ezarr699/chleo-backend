<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Model
 * @file        Pekerjaan.php
 * @path        Modules/Pekerjaan/Models/Pekerjaan.php
 * @description Model data master Pekerjaan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\Pekerjaan\Models;

use Database\Factories\PekerjaanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class Pekerjaan extends Model
{
    /** @use HasFactory<PekerjaanFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'pekerjaan';

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find PekerjaanFactory once the model moves to Modules\Pekerjaan\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): PekerjaanFactory
    {
        return PekerjaanFactory::new();
    }
}
