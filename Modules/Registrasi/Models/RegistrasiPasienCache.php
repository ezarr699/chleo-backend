<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Model
 * @file        RegistrasiPasienCache.php
 * @path        Modules/Registrasi/Models/RegistrasiPasienCache.php
 * @description Replika lokal data Pasien (id, nik, nama) yang dibutuhkan
 *              Registrasi untuk ditampilkan di Kunjungan — tabel terpisah
 *              dari RegistrasiMasterDataCache karena Pasien membawa kolom
 *              nik yang tidak ada di data master generik. Diisi lewat
 *              Listeners/SyncCrossModuleDataToRegistrasi.php, sama pola
 *              dengan Modules/Billing/Models/BillingPasienCache.php.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Models;

use Illuminate\Database\Eloquent\Model;

final class RegistrasiPasienCache extends Model
{
    protected $table = 'registrasi_pasien_cache';

    protected $fillable = [
        'pasien_id',
        'nik',
        'nama',
        'synced_at',
    ];

    protected function casts(): array
    {
        return [
            'synced_at' => 'datetime',
        ];
    }
}
