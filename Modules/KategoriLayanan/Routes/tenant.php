<?php
/**
 * ============================================================
 * @module      KategoriLayanan
 * @layer       Route
 * @file        tenant.php
 * @path        Modules/KategoriLayanan/Routes/tenant.php
 * @description Route HTTP untuk data master Kategori Layanan, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use Modules\KategoriLayanan\Controllers\KategoriLayananController;

Route::middleware(['auth:sanctum', 'permission:kategori_layanan.view'])
    ->get('kategori-layanan', [KategoriLayananController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:kategori_layanan.manage'])->group(function (): void {
    Route::post('kategori-layanan', [KategoriLayananController::class, 'store']);
    Route::put('kategori-layanan/{id}', [KategoriLayananController::class, 'update']);
    Route::delete('kategori-layanan/{id}', [KategoriLayananController::class, 'destroy']);
});
