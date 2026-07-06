<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Route
 * @file        tenant.php
 * @path        app/Modules/Pasien/Routes/tenant.php
 * @description Route HTTP untuk modul Pasien: CRUD dasar, verifikasi
 *              (permission terpisah `pasien.verifikasi`), dan toggle
 *              status aktif/nonaktif.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use App\Modules\Pasien\Controllers\PasienController;

Route::middleware(['auth:sanctum', 'permission:pasien.view'])->group(function () {
    Route::get('pasien', [PasienController::class, 'index']);
    Route::get('pasien/{id}', [PasienController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'permission:pasien.manage'])->group(function () {
    Route::post('pasien', [PasienController::class, 'store']);
    Route::put('pasien/{id}', [PasienController::class, 'update']);
    Route::patch('pasien/{id}/status', [PasienController::class, 'setStatus']);
    Route::delete('pasien/{id}', [PasienController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'permission:pasien.verifikasi'])
    ->post('pasien/{id}/verifikasi', [PasienController::class, 'verify']);
