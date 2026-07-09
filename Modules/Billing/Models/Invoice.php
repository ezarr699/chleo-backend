<?php
/**
 * ============================================================
 * @module      Billing
 * @layer       Model
 * @file        Invoice.php
 * @path        Modules/Billing/Models/Invoice.php
 * @description Model Invoice. Kolom nama_pasien_snapshot & no_rm_snapshot
 *              adalah SALINAN TEKS (Hukum Snapshot Data) yang diambil dari
 *              BillingPasienCache pada saat invoice dibuat — sengaja tidak
 *              memakai relasi Eloquent dinamis apa pun ke tabel pasien,
 *              supaya nilai di invoice lama tidak pernah berubah walau
 *              data master pasien diperbarui di kemudian hari.
 *              pasien_id disimpan sebagai kolom polos (unsignedBigInteger)
 *              TANPA foreign key constraint ke tabel pasien — modul
 *              Billing hanya boleh tahu bahwa BillingPasienCache pernah
 *              punya baris dengan pasien_id tsb, bukan tabel pasien itu
 *              sendiri (Hukum Isolasi Total Eloquent berlaku juga di
 *              level skema, bukan cuma di level kode PHP).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;

final class Invoice extends Model
{
    protected $table = 'invoice';

    protected $fillable = [
        'pasien_id',
        'nama_pasien_snapshot',
        'no_rm_snapshot',
        'deskripsi_layanan',
        'catatan',
        'subtotal',
        'pajak',
        'total',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'pajak' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }
}
