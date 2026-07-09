<?php
/**
 * ============================================================
 * @module      JenisKelamin
 * @layer       Model
 * @file        JenisKelamin.php
 * @path        Modules/JenisKelamin/Models/JenisKelamin.php
 * @description Model data master Jenis Kelamin.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\JenisKelamin\Models;

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

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find JenisKelaminFactory once the model moves to Modules\JenisKelamin\Models,
     * so the mapping has to be explicit here instead of relying on convention.
     */
    protected static function newFactory(): JenisKelaminFactory
    {
        return JenisKelaminFactory::new();
    }
}
