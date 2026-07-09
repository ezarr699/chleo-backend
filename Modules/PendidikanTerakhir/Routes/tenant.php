<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/PendidikanTerakhir/Routes/tenant.php
 * @description Route HTTP untuk data master Pendidikan Terakhir, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\PendidikanTerakhir\Controllers\PendidikanTerakhirController;

Route::middleware(['auth:sanctum', 'permission:pendidikan_terakhir.view'])
    ->get('pendidikan-terakhir', [PendidikanTerakhirController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:pendidikan_terakhir.manage'])->group(function (): void {
    Route::post('pendidikan-terakhir', [PendidikanTerakhirController::class, 'store']);
    Route::put('pendidikan-terakhir/{id}', [PendidikanTerakhirController::class, 'update']);
    Route::delete('pendidikan-terakhir/{id}', [PendidikanTerakhirController::class, 'destroy']);
});
