<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_06_000002_create_poliklinik_table.php
 * @path        database/migrations/tenant/2026_07_06_000002_create_poliklinik_table.php
 * @description Membuat tabel poliklinik (data master) di database tenant.
 * @rollback    Menghapus tabel poliklinik
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
        Schema::create('poliklinik', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poliklinik');
    }
};
