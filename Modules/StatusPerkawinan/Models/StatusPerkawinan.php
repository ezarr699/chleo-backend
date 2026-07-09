<?php
/**
 * ============================================================
 * @module      StatusPerkawinan
 * @layer       Model
 * @file        StatusPerkawinan.php
 * @path        Modules/StatusPerkawinan/Models/StatusPerkawinan.php
 * @description Model data master Status Perkawinan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\StatusPerkawinan\Models;

use Database\Factories\StatusPerkawinanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class StatusPerkawinan extends Model
{
    /** @use HasFactory<StatusPerkawinanFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'status_perkawinan';

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find StatusPerkawinanFactory once the model moves to Modules\StatusPerkawinan\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): StatusPerkawinanFactory
    {
        return StatusPerkawinanFactory::new();
    }
}
