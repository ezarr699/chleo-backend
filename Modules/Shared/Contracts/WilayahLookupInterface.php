<?php
/**
 * ============================================================
 * @module      Shared
 * @layer       Contract (Interface)
 * @file        WilayahLookupInterface.php
 * @path        Modules/Shared/Contracts/WilayahLookupInterface.php
 * @description Kontrak baca-saja untuk resolusi kode wilayah administratif
 *              (provinsi/kabupaten/kecamatan/kelurahan) ke nama teks,
 *              dipakai modul lain (mis. Pasien) tanpa perlu import Model
 *              Eloquent milik Modul Wilayah. Diikat lewat
 *              Wilayah\Providers\WilayahServiceProvider.
 *              Sengaja BUKAN pola cache-replica+event seperti
 *              Billing<->Pasien — data wilayah (~514 kabupaten/kota,
 *              puluhan ribu kelurahan dari paket laravolt/indonesia)
 *              adalah data referensi statis yang dibagikan IDENTIK ke
 *              semua tenant lewat koneksi central (lihat
 *              Modules/Wilayah/Models/Provinsi.php dkk, trait
 *              CentralConnection dari stancl/tenancy) — bukan hasil
 *              transaksi/CRUD yang berubah per tenant, jadi tidak ada
 *              event "dibuat/diperbarui" yang natural untuk memicu sync,
 *              dan mereplikasi ~80rb+ baris ke tiap modul konsumen jelas
 *              tidak masuk akal. Isolasi tetap ditegakkan di level tidak
 *              boleh ada `use Modules\Wilayah\Models\*` di modul lain —
 *              cukup lewat kontrak baca sempit ini, bukan lewat menyalin
 *              seluruh tabel referensi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Shared\Contracts;

interface WilayahLookupInterface
{
    public function namaProvinsi(?string $code): ?string;

    public function namaKabupaten(?string $code): ?string;

    public function namaKecamatan(?string $code): ?string;

    public function namaKelurahan(?string $code): ?string;

    public function kodeValid(?string $provinsiCode, ?string $kabupatenCode, ?string $kecamatanCode, ?string $kelurahanCode): bool;

    /**
     * Resolusi banyak kode sekaligus dalam satu query per tingkat — dipakai
     * saat menampilkan daftar (mis. index() pasien) supaya tidak N+1 query
     * per baris.
     *
     * @param  string  $tingkat  'provinsi'|'kabupaten'|'kecamatan'|'kelurahan'
     * @param  array<int, string>  $codes
     * @return array<string, string> kode => nama
     */
    public function namaBanyak(string $tingkat, array $codes): array;
}
