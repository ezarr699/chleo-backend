<?php

/**
 * ============================================================
 * @module      Wilayah
 * @layer       Model
 * @file        Kabupaten.php
 * @path        Modules/Wilayah/Models/Kabupaten.php
 * @description Data referensi kota/kabupaten dari paket laravolt/indonesia.
 *              Selalu memakai koneksi central (CentralConnection).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://github.com/laravolt/indonesia
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Wilayah\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

final class Kabupaten extends Model
{
    use CentralConnection;

    protected $table = 'indonesia_cities';

    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'province_code', 'code');
    }

    public function kecamatan(): HasMany
    {
        return $this->hasMany(Kecamatan::class, 'city_code', 'code');
    }
}
