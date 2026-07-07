<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Model
 * @file        Agama.php
 * @path        app/Models/Agama.php
 * @description Model data master Agama.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

use Database\Factories\AgamaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class Agama extends Model
{
    /** @use HasFactory<AgamaFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'agama';
}
