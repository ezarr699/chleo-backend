<?php
/**
 * ============================================================
 * @module      HubunganKeluarga
 * @layer       Model
 * @file        HubunganKeluarga.php
 * @path        app/Models/HubunganKeluarga.php
 * @description Model data master Hubungan Keluarga.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace App\Models;

use Database\Factories\HubunganKeluargaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class HubunganKeluarga extends Model
{
    /** @use HasFactory<HubunganKeluargaFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'hubungan_keluarga';
}
