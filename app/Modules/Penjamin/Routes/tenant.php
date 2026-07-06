<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Route
 * @file        tenant.php
 * @path        app/Modules/Penjamin/Routes/tenant.php
 * @description Route HTTP untuk data master Penjamin, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use App\Modules\Penjamin\Controllers\PenjaminController;

Route::middleware(['auth:sanctum', 'permission:penjamin.view'])
    ->get('penjamin', [PenjaminController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:penjamin.manage'])->group(function (): void {
    Route::post('penjamin', [PenjaminController::class, 'store']);
    Route::put('penjamin/{id}', [PenjaminController::class, 'update']);
    Route::delete('penjamin/{id}', [PenjaminController::class, 'destroy']);
});
