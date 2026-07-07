<?php
/**
 * ============================================================
 * @module      StatusPerkawinan
 * @layer       Model
 * @file        StatusPerkawinan.php
 * @path        app/Models/StatusPerkawinan.php
 * @description Model data master Status Perkawinan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

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
}
