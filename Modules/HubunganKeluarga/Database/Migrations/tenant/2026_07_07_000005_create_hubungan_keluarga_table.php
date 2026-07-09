<?php
/**
 * ============================================================
 * @module      HubunganKeluarga
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_07_000005_create_hubungan_keluarga_table.php
 * @path        Modules/HubunganKeluarga/Database/Migrations/tenant/2026_07_07_000005_create_hubungan_keluarga_table.php
 * @description Membuat tabel hubungan_keluarga (data master) di database tenant.
 * @rollback    Menghapus tabel hubungan_keluarga
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
        Schema::create('hubungan_keluarga', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hubungan_keluarga');
    }
};
