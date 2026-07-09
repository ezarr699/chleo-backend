<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_07_000003_create_pekerjaan_table.php
 * @path        Modules/Pekerjaan/Database/Migrations/tenant/2026_07_07_000003_create_pekerjaan_table.php
 * @description Membuat tabel pekerjaan (data master) di database tenant.
 * @rollback    Menghapus tabel pekerjaan
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
        Schema::create('pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pekerjaan');
    }
};
