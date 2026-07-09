<?php
/**
 * ============================================================
 * @module      Jkn
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/Jkn/Routes/tenant.php
 * @description Route HTTP untuk bridging V-Claim BPJS (JKN-01-2),
 *              dijalankan dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\Jkn\Controllers\VClaimController;

Route::middleware(['auth:sanctum', 'permission:bpjs_vclaim.view'])->group(function () {
    Route::get('bpjs/peserta', [VClaimController::class, 'eligibilitas']);
});

Route::middleware(['auth:sanctum', 'permission:bpjs_vclaim.manage'])->group(function () {
    Route::post('kunjungan/{id}/sep', [VClaimController::class, 'buatSep']);
});
