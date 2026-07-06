<?php
/**
 * ============================================================
 * @module      Auth
 * @layer       Route
 * @file        tenant.php
 * @path        app/Modules/Auth/Routes/tenant.php
 * @description Route HTTP untuk modul Auth: login, logout, me.
 *              Berjalan dalam konteks tenant (database tenant aktif)
 *              karena login harus melawan tabel users milik tenant
 *              tersebut, bukan database central.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Controllers\AuthController;

Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me', [AuthController::class, 'me']);
});
