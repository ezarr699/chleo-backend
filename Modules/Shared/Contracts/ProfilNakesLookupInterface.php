<?php
/**
 * ============================================================
 * @module      Shared
 * @layer       Contract (Interface)
 * @file        ProfilNakesLookupInterface.php
 * @path        Modules/Shared/Contracts/ProfilNakesLookupInterface.php
 * @description Kontrak baca-LANGSUNG (bukan cache) untuk ProfilNakes:
 *              praktikDiPoliklinik() memvalidasi apakah seorang nakes
 *              praktik di sebuah poliklinik SAAT INI, dipakai Registrasi
 *              untuk menggerbangi pembuatan Kunjungan. Sengaja live-read,
 *              bukan cache-replica — sama alasannya dengan
 *              KunjunganStatusInterface: penugasan nakes ke poliklinik
 *              bisa berubah, dan validasi registrasi harus memakai data
 *              ter-update, bukan cache yang mungkin basi.
 *              namaLengkap() dipakai RawatJalan untuk SNAPSHOT (Hukum
 *              Snapshot Data) nama nakes ke Pemeriksaan (rekam medis)
 *              pada saat pemeriksaan dicatat — beda alasan dari
 *              praktikDiPoliklinik() (bukan soal race condition, tapi
 *              soal rekam medis tidak boleh berubah walau data ProfilNakes
 *              di-update setelah pemeriksaan itu dibuat), tapi
 *              sama-sama butuh baca langsung, bukan tabel cache terpisah.
 *              Diikat lewat ProfilNakes\Providers\ProfilNakesServiceProvider.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Shared\Contracts;

interface ProfilNakesLookupInterface
{
    public function praktikDiPoliklinik(int $profilNakesId, int $poliklinikId): bool;

    public function namaLengkap(int $profilNakesId): ?string;
}
