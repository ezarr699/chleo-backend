<?php
/**
 * ============================================================
 * @module      KategoriObat
 * @layer       Route
 * @file        tenant.php
 * @path        app/Modules/KategoriObat/Routes/tenant.php
 * @description Route HTTP untuk data master Kategori Obat, dijalankan
 *              dalam konteks tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use App\Modules\KategoriObat\Controllers\KategoriObatController;

Route::middleware(['auth:sanctum', 'permission:kategori_obat.view'])
    ->get('kategori-obat', [KategoriObatController::class, 'index']);

Route::middleware(['auth:sanctum', 'permission:kategori_obat.manage'])->group(function (): void {
    Route::post('kategori-obat', [KategoriObatController::class, 'store']);
    Route::put('kategori-obat/{id}', [KategoriObatController::class, 'update']);
    Route::delete('kategori-obat/{id}', [KategoriObatController::class, 'destroy']);
});
