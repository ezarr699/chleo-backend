<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_09_000021_create_profil_nakes_user_cache_table.php
 * @path        Modules/ProfilNakes/Database/Migrations/tenant/2026_07_09_000021_create_profil_nakes_user_cache_table.php
 * @description Membuat tabel profil_nakes_user_cache (replika lokal
 *              User untuk ProfilNakes).
 * @rollback    Menghapus tabel profil_nakes_user_cache
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
        Schema::create('profil_nakes_user_cache', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama');
            $table->string('email');
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_nakes_user_cache');
    }
};
