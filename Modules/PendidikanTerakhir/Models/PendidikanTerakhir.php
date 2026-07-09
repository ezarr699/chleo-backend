<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Model
 * @file        PendidikanTerakhir.php
 * @path        Modules/PendidikanTerakhir/Models/PendidikanTerakhir.php
 * @description Model data master Pendidikan Terakhir.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\PendidikanTerakhir\Models;

use Database\Factories\PendidikanTerakhirFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class PendidikanTerakhir extends Model
{
    /** @use HasFactory<PendidikanTerakhirFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'pendidikan_terakhir';

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find PendidikanTerakhirFactory once the model moves to Modules\PendidikanTerakhir\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): PendidikanTerakhirFactory
    {
        return PendidikanTerakhirFactory::new();
    }
}
