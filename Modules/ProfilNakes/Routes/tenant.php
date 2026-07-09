<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/ProfilNakes/Routes/tenant.php
 * @description Route HTTP untuk resource ProfilNakes, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\ProfilNakes\Controllers\ProfilNakesController;

Route::middleware(['auth:sanctum', 'permission:profil_nakes.view'])
    ->get('profil-nakes', [ProfilNakesController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:profil_nakes.manage'])->group(function (): void {
    Route::post('profil-nakes', [ProfilNakesController::class, 'store']);
    Route::put('profil-nakes/{id}', [ProfilNakesController::class, 'update']);
    Route::delete('profil-nakes/{id}', [ProfilNakesController::class, 'destroy']);
});
