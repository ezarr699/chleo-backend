<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_07_000004_create_pendidikan_terakhir_table.php
 * @path        database/migrations/tenant/2026_07_07_000004_create_pendidikan_terakhir_table.php
 * @description Membuat tabel pendidikan_terakhir (data master) di database tenant.
 * @rollback    Menghapus tabel pendidikan_terakhir
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
        Schema::create('pendidikan_terakhir', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendidikan_terakhir');
    }
};
