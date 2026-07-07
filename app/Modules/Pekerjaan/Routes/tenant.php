<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Route
 * @file        tenant.php
 * @path        app/Modules/Pekerjaan/Routes/tenant.php
 * @description Route HTTP untuk data master Pekerjaan, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use App\Modules\Pekerjaan\Controllers\PekerjaanController;

Route::middleware(['auth:sanctum', 'permission:pekerjaan.view'])
    ->get('pekerjaan', [PekerjaanController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:pekerjaan.manage'])->group(function (): void {
    Route::post('pekerjaan', [PekerjaanController::class, 'store']);
    Route::put('pekerjaan/{id}', [PekerjaanController::class, 'update']);
    Route::delete('pekerjaan/{id}', [PekerjaanController::class, 'destroy']);
});
