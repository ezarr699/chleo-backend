<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Database > Migration (Tenant)
 * @file        2026_06_22_000010_create_penjamin_table.php
 * @path        database/migrations/tenant/2026_06_22_000010_create_penjamin_table.php
 * @description Membuat tabel penjamin (data master) di database tenant.
 * @rollback    Menghapus tabel penjamin
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
        Schema::create('penjamin', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjamin');
    }
};
