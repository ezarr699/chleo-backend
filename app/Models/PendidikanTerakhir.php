<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Model
 * @file        PendidikanTerakhir.php
 * @path        app/Models/PendidikanTerakhir.php
 * @description Model data master Pendidikan Terakhir.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

use Database\Factories\PendidikanTerakhirFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class PendidikanTerakhir extends Model
{
    /** @use HasFactory<PendidikanTerakhirFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'pendidikan_terakhir';
}
