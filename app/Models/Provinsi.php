<?php

/**
 * ============================================================
 * @module      Wilayah
 * @layer       Model
 * @file        Provinsi.php
 * @path        app/Models/Provinsi.php
 * @description Data referensi provinsi dari paket laravolt/indonesia.
 *              Selalu memakai koneksi central (CentralConnection) karena
 *              data wilayah identik untuk semua tenant dan disimpan
 *              sekali di database central, bukan diduplikasi per-tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://github.com/laravolt/indonesia
 * ============================================================
 */

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

final class Provinsi extends Model
{
    use CentralConnection;

    protected $table = 'indonesia_provinces';

    public function kabupaten(): HasMany
    {
        return $this->hasMany(Kabupaten::class, 'province_code', 'code');
    }
}
