<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/Poliklinik/Routes/tenant.php
 * @description Route HTTP untuk data master Poliklinik, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\Poliklinik\Controllers\PoliklinikController;

Route::middleware(['auth:sanctum', 'permission:poliklinik.view'])
    ->get('poliklinik', [PoliklinikController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:poliklinik.manage'])->group(function (): void {
    Route::post('poliklinik', [PoliklinikController::class, 'store']);
    Route::put('poliklinik/{id}', [PoliklinikController::class, 'update']);
    Route::delete('poliklinik/{id}', [PoliklinikController::class, 'destroy']);
});
