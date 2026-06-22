<?php
/**
 * ============================================================
 * @module      GolonganDarah
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/GolonganDarah/Routes/tenant.php
 * @description Route HTTP untuk data master Golongan Darah, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\GolonganDarah\Controllers\GolonganDarahController;

Route::middleware(['auth:sanctum', 'permission:golongan_darah.view'])
    ->get('golongan-darah', [GolonganDarahController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:golongan_darah.manage'])->group(function (): void {
    Route::post('golongan-darah', [GolonganDarahController::class, 'store']);
    Route::put('golongan-darah/{id}', [GolonganDarahController::class, 'update']);
    Route::delete('golongan-darah/{id}', [GolonganDarahController::class, 'destroy']);
});
