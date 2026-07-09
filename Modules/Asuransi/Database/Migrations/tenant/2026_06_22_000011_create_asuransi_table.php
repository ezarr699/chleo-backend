<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Database > Migration (Tenant)
 * @file        2026_06_22_000011_create_asuransi_table.php
 * @path        Modules/Asuransi/Database/Migrations/tenant/2026_06_22_000011_create_asuransi_table.php
 * @description Membuat tabel asuransi (data master) di database tenant.
 * @rollback    Menghapus tabel asuransi
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
        Schema::create('asuransi', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asuransi');
    }
};
