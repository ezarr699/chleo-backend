<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_07_000001_create_agama_table.php
 * @path        Modules/Agama/Database/Migrations/tenant/2026_07_07_000001_create_agama_table.php
 * @description Membuat tabel agama (data master) di database tenant.
 * @rollback    Menghapus tabel agama
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
        Schema::create('agama', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agama');
    }
};
