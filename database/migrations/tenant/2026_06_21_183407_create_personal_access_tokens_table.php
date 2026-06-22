<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Database > Migration (Tenant)
 * @file        2026_06_21_183407_create_personal_access_tokens_table.php
 * @path        database/migrations/tenant/2026_06_21_183407_create_personal_access_tokens_table.php
 * @description Membuat tabel personal_access_tokens (Sanctum) di database
 *              tenant — token milik user tenant, bukan central.
 * @rollback    Menghapus tabel personal_access_tokens
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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->text('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
