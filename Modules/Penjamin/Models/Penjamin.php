<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Model
 * @file        Penjamin.php
 * @path        Modules/Penjamin/Models/Penjamin.php
 * @description Model data master Penjamin. is_bpjs menandai penjamin
 *              mana yang merepresentasikan BPJS Kesehatan — dipakai
 *              modul Registrasi untuk menentukan kunjungan mana yang
 *              perlu disinkronkan ke bridging BPJS.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\Penjamin\Models;

use Database\Factories\PenjaminFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'is_bpjs'])]
class Penjamin extends Model
{
    /** @use HasFactory<PenjaminFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'penjamin';

    protected function casts(): array
    {
        return [
            'is_bpjs' => 'boolean',
        ];
    }

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find PenjaminFactory once the model moves to Modules\Penjamin\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): PenjaminFactory
    {
        return PenjaminFactory::new();
    }
}
