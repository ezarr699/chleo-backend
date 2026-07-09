<?php
/**
 * ============================================================
 * @module      Profesi
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_06_000001_create_profesi_table.php
 * @path        Modules/Profesi/Database/Migrations/tenant/2026_07_06_000001_create_profesi_table.php
 * @description Membuat tabel profesi (data master) di database tenant.
 * @rollback    Menghapus tabel profesi
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
        Schema::create('profesi', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profesi');
    }
};
