<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/Satuan/Routes/tenant.php
 * @description Route HTTP untuk data master Satuan, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\Satuan\Controllers\SatuanController;

Route::middleware(['auth:sanctum', 'permission:satuan.view'])
    ->get('satuan', [SatuanController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:satuan.manage'])->group(function (): void {
    Route::post('satuan', [SatuanController::class, 'store']);
    Route::put('satuan/{id}', [SatuanController::class, 'update']);
    Route::delete('satuan/{id}', [SatuanController::class, 'destroy']);
});
