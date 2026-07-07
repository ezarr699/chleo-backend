<?php
/**
 * ============================================================
 * @module      KategoriTriase
 * @layer       Model
 * @file        KategoriTriase.php
 * @path        app/Models/KategoriTriase.php
 * @description Model data master Kategori Triase.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

use Database\Factories\KategoriTriaseFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class KategoriTriase extends Model
{
    /** @use HasFactory<KategoriTriaseFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'kategori_triase';
}
