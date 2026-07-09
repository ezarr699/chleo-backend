<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Model
 * @file        Agama.php
 * @path        Modules/Agama/Models/Agama.php
 * @description Model data master Agama.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\Agama\Models;

use Database\Factories\AgamaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class Agama extends Model
{
    /** @use HasFactory<AgamaFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'agama';

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ — it
     * cannot find AgamaFactory once the model moves to Modules\Agama\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): AgamaFactory
    {
        return AgamaFactory::new();
    }
}
