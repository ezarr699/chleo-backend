<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Database > Migration (Tenant)
 * @file        0001_01_01_000001_create_cache_table.php
 * @path        database/migrations/tenant/0001_01_01_000001_create_cache_table.php
 * @description Membuat tabel cache & cache_locks di database tenant.
 * @rollback    Menghapus tabel cache, cache_locks
 * @since       v1.0.0
 * ============================================================
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->bigInteger('expiration')->index();
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->bigInteger('expiration')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
