<?php
/**
 * ============================================================
 * @module      Profesi
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/Profesi/Routes/tenant.php
 * @description Route HTTP untuk data master Profesi, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\Profesi\Controllers\ProfesiController;

Route::middleware(['auth:sanctum', 'permission:profesi.view'])
    ->get('profesi', [ProfesiController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:profesi.manage'])->group(function (): void {
    Route::post('profesi', [ProfesiController::class, 'store']);
    Route::put('profesi/{id}', [ProfesiController::class, 'update']);
    Route::delete('profesi/{id}', [ProfesiController::class, 'destroy']);
});
