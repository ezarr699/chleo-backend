<?php
/**
 * ============================================================
 * @module      Billing
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_09_000001_create_billing_pasien_cache_table.php
 * @path        Modules/Billing/Database/Migrations/tenant/2026_07_09_000001_create_billing_pasien_cache_table.php
 * @description Membuat tabel billing_pasien_cache: replika lokal minimal
 *              data Pasien (pasien_id, nama_lengkap, no_rm) milik Modul
 *              Billing. Tabel TENANT (satu per database tenant) — path
 *              folder ini (Database/Migrations/tenant/) di-load lewat
 *              config/tenancy.php migration_parameters, HANYA jalan lewat
 *              `php artisan tenants:migrate`, bukan `migrate` biasa.
 *              pasien_id sengaja tanpa foreign key ke tabel pasien
 *              (lihat Models/BillingPasienCache.php).
 * @rollback    Menghapus tabel billing_pasien_cache
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('billing_pasien_cache', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('pasien_id');
            $table->string('nama_lengkap');
            $table->string('no_rm')->nullable();
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();

            $table->unique('pasien_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_pasien_cache');
    }
};
