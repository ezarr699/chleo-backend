<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/IntegrationLog/Routes/tenant.php
 * @description Route HTTP untuk dashboard admin monitoring log
 *              integrasi (resource: integration-log), dijalankan dalam
 *              konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\IntegrationLog\Controllers\IntegrationLogController;

Route::middleware(['auth:sanctum', 'permission:log_integrasi.view'])->group(function () {
    Route::get('integration-log', [IntegrationLogController::class, 'index']);
    Route::get('integration-log/{id}', [IntegrationLogController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'permission:log_integrasi.manage'])->group(function () {
    Route::post('integration-log/{id}/investigate', [IntegrationLogController::class, 'investigate']);
    Route::post('integration-log/{id}/resolve', [IntegrationLogController::class, 'resolve']);
});
