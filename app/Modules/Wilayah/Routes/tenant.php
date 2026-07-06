<?php
/**
 * ============================================================
 * @module      Wilayah
 * @layer       Route
 * @file        tenant.php
 * @path        app/Modules/Wilayah/Routes/tenant.php
 * @description Route lookup data wilayah (provinsi/kabupaten/kecamatan/
 *              kelurahan) + deteksi lokasi dari koordinat browser,
 *              dijalankan dalam konteks tenant. Tanpa permission khusus —
 *              data referensi baca-saja, tidak ada konsep "manage" untuk
 *              dijaga. `deteksi-lokasi` diberi throttle terpisah karena
 *              memanggil layanan reverse-geocode eksternal (Nominatim).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Support\Facades\Route;
use App\Modules\Wilayah\Controllers\WilayahController;

Route::middleware(['auth:sanctum'])->group(function (): void {
    Route::get('wilayah/provinsi', [WilayahController::class, 'provinsi']);
    Route::get('wilayah/kabupaten', [WilayahController::class, 'kabupaten']);
    Route::get('wilayah/kecamatan', [WilayahController::class, 'kecamatan']);
    Route::get('wilayah/kelurahan', [WilayahController::class, 'kelurahan']);
});

Route::middleware(['auth:sanctum', 'throttle:10,1'])
    ->get('wilayah/deteksi-lokasi', [WilayahController::class, 'deteksiLokasi']);
