<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/Agama/Routes/tenant.php
 * @description Route HTTP untuk data master Agama, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\Agama\Controllers\AgamaController;

Route::middleware(['auth:sanctum', 'permission:agama.view'])
    ->get('agama', [AgamaController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:agama.manage'])->group(function (): void {
    Route::post('agama', [AgamaController::class, 'store']);
    Route::put('agama/{id}', [AgamaController::class, 'update']);
    Route::delete('agama/{id}', [AgamaController::class, 'destroy']);
});
