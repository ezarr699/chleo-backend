<?php
/**
 * ============================================================
 * @module      KategoriTriase
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_06_000006_create_kategori_triase_table.php
 * @path        Modules/KategoriTriase/Database/Migrations/tenant/2026_07_06_000006_create_kategori_triase_table.php
 * @description Membuat tabel kategori_triase (data master) di database tenant.
 * @rollback    Menghapus tabel kategori_triase
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
        Schema::create('kategori_triase', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_triase');
    }
};
