<?php
/**
 * ============================================================
 * @module      Shared
 * @layer       Contract (Interface)
 * @file        PoliklinikLookupInterface.php
 * @path        Modules/Shared/Contracts/PoliklinikLookupInterface.php
 * @description Kontrak baca-LANGSUNG untuk menghitung prefix nomor antrian
 *              sebuah Poliklinik (dari kode_bpjs kalau ada, atau 3 huruf
 *              awal namanya), dipakai Registrasi saat membuat Kunjungan
 *              baru. Bagaimana cara menurunkan prefix dari data Poliklinik
 *              adalah pengetahuan milik Modul Poliklinik sendiri —
 *              Registrasi cukup minta hasilnya tanpa perlu mengimpor
 *              Model Poliklinik. Diikat lewat
 *              Poliklinik\Providers\PoliklinikServiceProvider.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Shared\Contracts;

interface PoliklinikLookupInterface
{
    public function antrianPrefix(int $poliklinikId): string;
}
