<?php
/**
 * ============================================================
 * @module      JenisKelamin
 * @layer       Model
 * @file        JenisKelamin.php
 * @path        app/Models/JenisKelamin.php
 * @description Model data master Jenis Kelamin.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

use Database\Factories\JenisKelaminFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class JenisKelamin extends Model
{
    /** @use HasFactory<JenisKelaminFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'jenis_kelamin';
}
