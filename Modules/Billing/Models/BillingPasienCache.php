<?php
/**
 * ============================================================
 * @module      Billing
 * @layer       Model
 * @file        BillingPasienCache.php
 * @path        Modules/Billing/Models/BillingPasienCache.php
 * @description Replika lokal (bukan relasi Eloquent) dari data minimal
 *              Pasien yang dibutuhkan Modul Billing: pasien_id,
 *              nama_lengkap, no_rm. Diisi/diperbarui HANYA lewat
 *              Listeners/SyncPasienToBilling.php yang menangkap Global
 *              Event App\Events\PasienCreatedOrUpdated. Modul ini
 *              TIDAK PERNAH meng-import App\Models\Pasien — inilah
 *              wujud konkret Hukum Isolasi Total Eloquent sekaligus
 *              yang menjamin staf/kode Billing tidak bisa menjangkau
 *              kolom rekam medis apa pun milik Pasien (kolom itu memang
 *              tidak ada di tabel ini).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;

final class BillingPasienCache extends Model
{
    protected $table = 'billing_pasien_cache';

    protected $fillable = [
        'pasien_id',
        'nama_lengkap',
        'no_rm',
        'synced_at',
    ];

    protected function casts(): array
    {
        return [
            'synced_at' => 'datetime',
        ];
    }
}
