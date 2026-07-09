<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_09_000040_create_integration_log_user_cache_table.php
 * @path        Modules/IntegrationLog/Database/Migrations/tenant/2026_07_09_000040_create_integration_log_user_cache_table.php
 * @description Membuat tabel integration_log_user_cache (replika lokal
 *              User untuk IntegrationLog, field resolved_by).
 * @rollback    Menghapus tabel integration_log_user_cache
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integration_log_user_cache', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama');
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integration_log_user_cache');
    }
};
