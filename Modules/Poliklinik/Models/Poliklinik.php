<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Model
 * @file        Poliklinik.php
 * @path        Modules/Poliklinik/Models/Poliklinik.php
 * @description Model data master Poliklinik. kode_bpjs = kode poli versi
 *              BPJS, dipakai saat bridging Antrean (field `kodepoli`).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\Poliklinik\Models;

use Database\Factories\PoliklinikFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'kode_bpjs'])]
class Poliklinik extends Model
{
    /** @use HasFactory<PoliklinikFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'poliklinik';

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find PoliklinikFactory once the model moves to Modules\Poliklinik\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): PoliklinikFactory
    {
        return PoliklinikFactory::new();
    }
}
