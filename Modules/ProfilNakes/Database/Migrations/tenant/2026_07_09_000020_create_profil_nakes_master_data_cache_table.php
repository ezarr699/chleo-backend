<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_09_000020_create_profil_nakes_master_data_cache_table.php
 * @path        Modules/ProfilNakes/Database/Migrations/tenant/2026_07_09_000020_create_profil_nakes_master_data_cache_table.php
 * @description Membuat tabel profil_nakes_master_data_cache (replika
 *              lokal generik Profesi/Poliklinik untuk ProfilNakes).
 * @rollback    Menghapus tabel profil_nakes_master_data_cache
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
        Schema::create('profil_nakes_master_data_cache', function (Blueprint $table): void {
            $table->id();
            $table->string('modul');
            $table->unsignedBigInteger('ref_id');
            $table->string('nama');
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();

            $table->unique(['modul', 'ref_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_nakes_master_data_cache');
    }
};
