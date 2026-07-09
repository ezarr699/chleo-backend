<?php

/**
 * ============================================================
 * @module      Wilayah
 * @layer       Model
 * @file        Kelurahan.php
 * @path        Modules/Wilayah/Models/Kelurahan.php
 * @description Data referensi kelurahan/desa dari paket laravolt/indonesia.
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
use Stancl\Tenancy\Database\Concerns\CentralConnection;

final class Kelurahan extends Model
{
    use CentralConnection;

    protected $table = 'indonesia_villages';

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'district_code', 'code');
    }
}
