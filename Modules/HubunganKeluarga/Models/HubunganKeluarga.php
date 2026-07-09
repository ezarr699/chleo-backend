<?php
/**
 * ============================================================
 * @module      HubunganKeluarga
 * @layer       Model
 * @file        HubunganKeluarga.php
 * @path        Modules/HubunganKeluarga/Models/HubunganKeluarga.php
 * @description Model data master Hubungan Keluarga.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\HubunganKeluarga\Models;

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

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find HubunganKeluargaFactory once the model moves to Modules\HubunganKeluarga\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): HubunganKeluargaFactory
    {
        return HubunganKeluargaFactory::new();
    }
}
