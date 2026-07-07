<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Model
 * @file        Pekerjaan.php
 * @path        app/Models/Pekerjaan.php
 * @description Model data master Pekerjaan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

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
}
