<?php

/**
 * ============================================================
 * @module      Wilayah
 * @layer       Model
 * @file        Kecamatan.php
 * @path        app/Models/Kecamatan.php
 * @description Data referensi kecamatan dari paket laravolt/indonesia.
 *              Selalu memakai koneksi central (CentralConnection).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://github.com/laravolt/indonesia
 * ============================================================
 */

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

final class Kecamatan extends Model
{
    use CentralConnection;

    protected $table = 'indonesia_districts';

    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class, 'city_code', 'code');
    }

    public function kelurahan(): HasMany
    {
        return $this->hasMany(Kelurahan::class, 'district_code', 'code');
    }
}
