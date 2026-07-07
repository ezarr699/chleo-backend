<?php
/**
 * ============================================================
 * @module      StatusPerkawinan
 * @layer       Route
 * @file        tenant.php
 * @path        app/Modules/StatusPerkawinan/Routes/tenant.php
 * @description Route HTTP untuk data master Status Perkawinan, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use App\Modules\StatusPerkawinan\Controllers\StatusPerkawinanController;

Route::middleware(['auth:sanctum', 'permission:status_perkawinan.view'])
    ->get('status-perkawinan', [StatusPerkawinanController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:status_perkawinan.manage'])->group(function (): void {
    Route::post('status-perkawinan', [StatusPerkawinanController::class, 'store']);
    Route::put('status-perkawinan/{id}', [StatusPerkawinanController::class, 'update']);
    Route::delete('status-perkawinan/{id}', [StatusPerkawinanController::class, 'destroy']);
});
