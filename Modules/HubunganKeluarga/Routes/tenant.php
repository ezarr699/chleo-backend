<?php
/**
 * ============================================================
 * @module      HubunganKeluarga
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/HubunganKeluarga/Routes/tenant.php
 * @description Route HTTP untuk data master Hubungan Keluarga, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\HubunganKeluarga\Controllers\HubunganKeluargaController;

Route::middleware(['auth:sanctum', 'permission:hubungan_keluarga.view'])
    ->get('hubungan-keluarga', [HubunganKeluargaController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:hubungan_keluarga.manage'])->group(function (): void {
    Route::post('hubungan-keluarga', [HubunganKeluargaController::class, 'store']);
    Route::put('hubungan-keluarga/{id}', [HubunganKeluargaController::class, 'update']);
    Route::delete('hubungan-keluarga/{id}', [HubunganKeluargaController::class, 'destroy']);
});
