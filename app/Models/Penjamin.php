<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Model
 * @file        Penjamin.php
 * @path        app/Models/Penjamin.php
 * @description Model data master Penjamin.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

use Database\Factories\PenjaminFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class Penjamin extends Model
{
    /** @use HasFactory<PenjaminFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'penjamin';
}
