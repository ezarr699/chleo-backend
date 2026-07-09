<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_09_000031_create_registrasi_pasien_cache_table.php
 * @path        Modules/Registrasi/Database/Migrations/tenant/2026_07_09_000031_create_registrasi_pasien_cache_table.php
 * @description Membuat tabel registrasi_pasien_cache (replika lokal
 *              Pasien untuk Registrasi).
 * @rollback    Menghapus tabel registrasi_pasien_cache
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
        Schema::create('registrasi_pasien_cache', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('pasien_id');
            $table->string('nik');
            $table->string('nama');
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();

            $table->unique('pasien_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrasi_pasien_cache');
    }
};
