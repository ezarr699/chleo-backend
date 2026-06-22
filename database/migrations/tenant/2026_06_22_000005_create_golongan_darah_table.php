<?php
/**
 * ============================================================
 * @module      GolonganDarah
 * @layer       Database > Migration (Tenant)
 * @file        2026_06_22_000005_create_golongan_darah_table.php
 * @path        database/migrations/tenant/2026_06_22_000005_create_golongan_darah_table.php
 * @description Membuat tabel golongan_darah (data master) di database tenant.
 * @rollback    Menghapus tabel golongan_darah
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
        Schema::create('golongan_darah', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('golongan_darah');
    }
};
