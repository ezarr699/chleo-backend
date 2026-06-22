<?php
/**
 * ============================================================
 * @module      GolonganDarah
 * @layer       Model
 * @file        GolonganDarah.php
 * @path        app/Models/GolonganDarah.php
 * @description Model data master Golongan Darah.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

use Database\Factories\GolonganDarahFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class GolonganDarah extends Model
{
    /** @use HasFactory<GolonganDarahFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'golongan_darah';
}
