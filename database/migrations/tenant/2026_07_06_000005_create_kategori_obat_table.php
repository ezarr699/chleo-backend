<?php
/**
 * ============================================================
 * @module      KategoriObat
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_06_000005_create_kategori_obat_table.php
 * @path        database/migrations/tenant/2026_07_06_000005_create_kategori_obat_table.php
 * @description Membuat tabel kategori_obat (data master) di database tenant.
 * @rollback    Menghapus tabel kategori_obat
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_obat', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_obat');
    }
};
