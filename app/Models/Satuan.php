<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Model
 * @file        Satuan.php
 * @path        app/Models/Satuan.php
 * @description Model data master Satuan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

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
}
