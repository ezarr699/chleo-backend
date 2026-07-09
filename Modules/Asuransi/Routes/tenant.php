<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/Asuransi/Routes/tenant.php
 * @description Route HTTP untuk data master Asuransi, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\Asuransi\Controllers\AsuransiController;

Route::middleware(['auth:sanctum', 'permission:asuransi.view'])
    ->get('asuransi', [AsuransiController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:asuransi.manage'])->group(function (): void {
    Route::post('asuransi', [AsuransiController::class, 'store']);
    Route::put('asuransi/{id}', [AsuransiController::class, 'update']);
    Route::delete('asuransi/{id}', [AsuransiController::class, 'destroy']);
});
