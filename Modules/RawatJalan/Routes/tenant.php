<?php
/**
 * ============================================================
 * @module      RawatJalan
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/RawatJalan/Routes/tenant.php
 * @description Route HTTP untuk pemeriksaan rawat jalan (RWJ-01-1),
 *              dijalankan dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\RawatJalan\Controllers\RawatJalanController;

Route::middleware(['auth:sanctum', 'permission:pemeriksaan.view'])
    ->get('kunjungan/{id}/pemeriksaan', [RawatJalanController::class, 'show']);

Route::middleware(['auth:sanctum', 'permission:pemeriksaan.manage'])->group(function () {
    Route::post('kunjungan/{id}/pemeriksaan', [RawatJalanController::class, 'store']);
    Route::put('kunjungan/{id}/pemeriksaan', [RawatJalanController::class, 'update']);
});
