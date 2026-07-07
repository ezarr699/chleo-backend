<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Model
 * @file        Poliklinik.php
 * @path        app/Models/Poliklinik.php
 * @description Model data master Poliklinik.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

use Database\Factories\PoliklinikFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class Poliklinik extends Model
{
    /** @use HasFactory<PoliklinikFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'poliklinik';
}
