<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Database > Migration (Tenant)
 * @file        0001_01_01_000000_create_users_table.php
 * @path        database/migrations/tenant/0001_01_01_000000_create_users_table.php
 * @description Membuat tabel users, password_reset_tokens, sessions
 *              di DALAM database tenant (bukan central). Dipindahkan
 *              dari database/migrations/ ke sini karena setiap tenant
 *              punya database sendiri (database-per-tenant).
 * @rollback    Menghapus tabel users, password_reset_tokens, sessions
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
