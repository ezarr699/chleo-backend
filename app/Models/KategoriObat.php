<?php
/**
 * ============================================================
 * @module      KategoriObat
 * @layer       Model
 * @file        KategoriObat.php
 * @path        app/Models/KategoriObat.php
 * @description Model data master Kategori Obat.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

use Database\Factories\KategoriObatFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class KategoriObat extends Model
{
    /** @use HasFactory<KategoriObatFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'kategori_obat';
}
