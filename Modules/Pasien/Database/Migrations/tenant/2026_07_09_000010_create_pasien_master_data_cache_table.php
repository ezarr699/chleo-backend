<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_09_000010_create_pasien_master_data_cache_table.php
 * @path        Modules/Pasien/Database/Migrations/tenant/2026_07_09_000010_create_pasien_master_data_cache_table.php
 * @description Membuat tabel pasien_master_data_cache: replika lokal
 *              generik (id + name) dari data master lintas modul yang
 *              dibutuhkan Pasien (JenisKelamin, GolonganDarah, Asuransi).
 *              modul+ref_id sengaja TANPA foreign key ke tabel sumbernya
 *              (Hukum Isolasi Total Eloquent berlaku di level skema juga).
 * @rollback    Menghapus tabel pasien_master_data_cache
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
        Schema::create('pasien_master_data_cache', function (Blueprint $table): void {
            $table->id();
            $table->string('modul');
            $table->unsignedBigInteger('ref_id');
            $table->string('nama');
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();

            $table->unique(['modul', 'ref_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasien_master_data_cache');
    }
};
