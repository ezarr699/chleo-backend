<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Model
 * @file        Asuransi.php
 * @path        app/Models/Asuransi.php
 * @description Model data master Asuransi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

use Database\Factories\AsuransiFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class Asuransi extends Model
{
    /** @use HasFactory<AsuransiFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'asuransi';
}
