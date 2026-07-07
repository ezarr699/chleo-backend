<?php
/**
 * ============================================================
 * @module      KategoriLayanan
 * @layer       Model
 * @file        KategoriLayanan.php
 * @path        app/Models/KategoriLayanan.php
 * @description Model data master Kategori Layanan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

use Database\Factories\KategoriLayananFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class KategoriLayanan extends Model
{
    /** @use HasFactory<KategoriLayananFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'kategori_layanan';
}
