<?php
/**
 * ============================================================
 * @module      KategoriTriase
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/KategoriTriase/Routes/tenant.php
 * @description Route HTTP untuk data master Kategori Triase, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\KategoriTriase\Controllers\KategoriTriaseController;

Route::middleware(['auth:sanctum', 'permission:kategori_triase.view'])
    ->get('kategori-triase', [KategoriTriaseController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:kategori_triase.manage'])->group(function (): void {
    Route::post('kategori-triase', [KategoriTriaseController::class, 'store']);
    Route::put('kategori-triase/{id}', [KategoriTriaseController::class, 'update']);
    Route::delete('kategori-triase/{id}', [KategoriTriaseController::class, 'destroy']);
});
