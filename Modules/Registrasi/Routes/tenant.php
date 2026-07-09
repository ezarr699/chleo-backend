<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/Registrasi/Routes/tenant.php
 * @description Route HTTP untuk modul Registrasi (resource: kunjungan),
 *              termasuk entry point rujukan masuk/keluar (REG-01-2) dan
 *              online booking Mobile JKN/Web Portal (REG-01-3),
 *              dijalankan dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\Registrasi\Controllers\RegistrasiController;

Route::middleware(['auth:sanctum', 'permission:kunjungan.view'])->group(function () {
    Route::get('kunjungan', [RegistrasiController::class, 'index']);
    Route::get('kunjungan/{id}', [RegistrasiController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'permission:kunjungan.manage'])->group(function () {
    Route::post('kunjungan', [RegistrasiController::class, 'store']);
    Route::post('kunjungan/rujukan-masuk', [RegistrasiController::class, 'rujukanMasuk']);
    Route::post('kunjungan/{id}/rujukan-keluar', [RegistrasiController::class, 'rujukanKeluar']);
    Route::post('kunjungan/booking', [RegistrasiController::class, 'booking']);
    Route::post('kunjungan/{id}/checkin', [RegistrasiController::class, 'checkin']);
    Route::post('kunjungan/{id}/panggil', [RegistrasiController::class, 'panggil']);
    Route::post('kunjungan/{id}/selesai', [RegistrasiController::class, 'selesai']);
    Route::post('kunjungan/{id}/batal', [RegistrasiController::class, 'batal']);
});
