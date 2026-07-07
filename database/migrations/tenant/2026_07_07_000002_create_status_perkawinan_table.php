<?php
/**
 * ============================================================
 * @module      StatusPerkawinan
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_07_000002_create_status_perkawinan_table.php
 * @path        database/migrations/tenant/2026_07_07_000002_create_status_perkawinan_table.php
 * @description Membuat tabel status_perkawinan (data master) di database tenant.
 * @rollback    Menghapus tabel status_perkawinan
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
        Schema::create('status_perkawinan', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_perkawinan');
    }
};
