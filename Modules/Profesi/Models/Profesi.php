<?php
/**
 * ============================================================
 * @module      Profesi
 * @layer       Model
 * @file        Profesi.php
 * @path        Modules/Profesi/Models/Profesi.php
 * @description Model data master Profesi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\Profesi\Models;

use Database\Factories\ProfesiFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class Profesi extends Model
{
    /** @use HasFactory<ProfesiFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'profesi';

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find ProfesiFactory once the model moves to Modules\Profesi\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): ProfesiFactory
    {
        return ProfesiFactory::new();
    }
}
