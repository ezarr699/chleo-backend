<?php
/**
 * ============================================================
 * @module      JenisKelamin
 * @layer       Route
 * @file        tenant.php
 * @path        app/Modules/JenisKelamin/Routes/tenant.php
 * @description Route HTTP untuk data master Jenis Kelamin, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use App\Modules\JenisKelamin\Controllers\JenisKelaminController;

Route::middleware(['auth:sanctum', 'permission:jenis_kelamin.view'])
    ->get('jenis-kelamin', [JenisKelaminController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:jenis_kelamin.manage'])->group(function (): void {
    Route::post('jenis-kelamin', [JenisKelaminController::class, 'store']);
    Route::put('jenis-kelamin/{id}', [JenisKelaminController::class, 'update']);
    Route::delete('jenis-kelamin/{id}', [JenisKelaminController::class, 'destroy']);
});
