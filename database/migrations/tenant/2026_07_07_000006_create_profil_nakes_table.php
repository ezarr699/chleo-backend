<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_07_000006_create_profil_nakes_table.php
 * @path        database/migrations/tenant/2026_07_07_000006_create_profil_nakes_table.php
 * @description Membuat tabel profil_nakes: menandai User sebagai tenaga
 *              kesehatan (profesi, poliklinik, SIP/STR). Satu User hanya
 *              boleh punya satu profil (user_id unik).
 * @rollback    Menghapus tabel profil_nakes
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
        Schema::create('profil_nakes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->foreignId('profesi_id')->constrained('profesi');
            $table->foreignId('poliklinik_id')->nullable()->constrained('poliklinik')->nullOnDelete();
            $table->string('no_sip')->nullable();
            $table->string('no_str')->nullable();
            $table->date('str_berlaku_sampai')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_nakes');
    }
};
