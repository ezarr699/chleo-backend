<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_08_000004_create_urutan_registrasi_harian_table.php
 * @path        database/migrations/tenant/2026_07_08_000004_create_urutan_registrasi_harian_table.php
 * @description Tabel counter global no_registrasi per hari (satu baris
 *              per tanggal). Dipakai RegistrasiRepository dengan
 *              lockForUpdate() supaya penomoran tetap urut & tanpa
 *              duplikat walau banyak loket mendaftar bersamaan di jam
 *              sibuk pagi hari. Tidak diekspos lewat API — murni
 *              infrastruktur penomoran.
 * @rollback    Menghapus tabel urutan_registrasi_harian
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
        Schema::create('urutan_registrasi_harian', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique();
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('urutan_registrasi_harian');
    }
};
