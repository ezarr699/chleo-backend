<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_08_000005_create_urutan_antrian_poliklinik_table.php
 * @path        database/migrations/tenant/2026_07_08_000005_create_urutan_antrian_poliklinik_table.php
 * @description Tabel counter no_antrian per poliklinik per hari (satu
 *              baris per tanggal+poliklinik). Nilai `urutan` di sini
 *              adalah sumber untuk kolom kunjungan.angka_antrian, yang
 *              formatnya sama dengan field `angkaantrean` pada bridging
 *              Antrean BPJS. Dipakai dengan lockForUpdate() seperti
 *              urutan_registrasi_harian.
 * @rollback    Menghapus tabel urutan_antrian_poliklinik
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
        Schema::create('urutan_antrian_poliklinik', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('poliklinik_id')->constrained('poliklinik')->cascadeOnDelete();
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();

            $table->unique(['tanggal', 'poliklinik_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('urutan_antrian_poliklinik');
    }
};
