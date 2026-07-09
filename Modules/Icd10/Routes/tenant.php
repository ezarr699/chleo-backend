<?php
/**
 * ============================================================
 * @module      Icd10
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/Icd10/Routes/tenant.php
 * @description Route HTTP untuk data master Icd10 (RWJ-01-1-1),
 *              dijalankan dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\Icd10\Controllers\Icd10Controller;

Route::middleware(['auth:sanctum', 'permission:icd10.view'])->group(function () {
    Route::get('icd10', [Icd10Controller::class, 'index']);
    Route::get('icd10/search', [Icd10Controller::class, 'search']);
});

Route::middleware(['auth:sanctum', 'permission:icd10.manage'])->group(function () {
    Route::post('icd10', [Icd10Controller::class, 'store']);
});
