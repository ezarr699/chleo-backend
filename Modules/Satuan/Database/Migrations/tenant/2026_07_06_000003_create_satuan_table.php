<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_06_000003_create_satuan_table.php
 * @path        Modules/Satuan/Database/Migrations/tenant/2026_07_06_000003_create_satuan_table.php
 * @description Membuat tabel satuan (data master) di database tenant.
 * @rollback    Menghapus tabel satuan
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
        Schema::create('satuan', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satuan');
    }
};
