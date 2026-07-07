<?php
/**
 * ============================================================
 * @module      Profesi
 * @layer       Model
 * @file        Profesi.php
 * @path        app/Models/Profesi.php
 * @description Model data master Profesi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

use Database\Factories\ProfesiFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class Profesi extends Model
{
    /** @use HasFactory<ProfesiFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'profesi';
}
