<?php
/**
 * ============================================================
 * @module      Billing
 * @layer       Route (Tenant)
 * @file        tenant.php
 * @path        Modules/Billing/Routes/tenant.php
 * @description Route HTTP Modul Billing. File ini bernama tenant.php
 *              (bukan api.php) SENGAJA — Invoice & BillingPasienCache
 *              adalah data per-tenant (satu klinik/tenant satu database),
 *              persis seperti data Pasien yang menjadi sumbernya. Diambil
 *              otomatis oleh Modules/BaseServiceProvider.php dan dibungkus
 *              middleware inisialisasi tenancy yang sama dengan yang
 *              dipakai modul Pasien, supaya request tanpa konteks tenant
 *              yang valid tidak pernah bisa menyentuh data billing.
 *              Permission billing.view/billing.manage dipisah dari
 *              pasien.view/pasien.manage — staf billing tidak otomatis
 *              dapat akses data pasien, dan sebaliknya.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Billing\Controllers\BillingApiController;

Route::middleware(['auth:sanctum', 'permission:billing.view'])->group(function (): void {
    Route::get('billing/invoice', [BillingApiController::class, 'index']);
    Route::get('billing/invoice/{id}', [BillingApiController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'permission:billing.manage'])
    ->post('billing/invoice', [BillingApiController::class, 'store']);
