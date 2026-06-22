<?php
/**
 * ============================================================
 * @module      JenisKelamin
 * @layer       Database > Migration (Tenant)
 * @file        2026_06_22_000009_create_jenis_kelamin_table.php
 * @path        database/migrations/tenant/2026_06_22_000009_create_jenis_kelamin_table.php
 * @description Membuat tabel jenis_kelamin (data master) di database tenant.
 * @rollback    Menghapus tabel jenis_kelamin
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
        Schema::create('jenis_kelamin', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_kelamin');
    }
};
