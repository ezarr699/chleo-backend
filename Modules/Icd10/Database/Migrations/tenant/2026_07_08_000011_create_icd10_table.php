<?php
/**
 * ============================================================
 * @module      Icd10
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_08_000011_create_icd10_table.php
 * @path        Modules/Icd10/Database/Migrations/tenant/2026_07_08_000011_create_icd10_table.php
 * @description Membuat tabel icd10 (RWJ-01-1-1) — master data kode
 *              diagnosis standar WHO ICD-10. kode unik (mis. "J00",
 *              "E11.9"), deskripsi teks diagnosis, kategori nullable
 *              (bab/chapter ICD-10, mis. "Penyakit sistem pernapasan").
 *              Index prefix di kode & deskripsi supaya search/autocomplete
 *              (RWJ-01-1-1) tetap cepat pada LIKE 'keyword%'. Seeder
 *              hanya mengisi subset kode yang umum dipakai rawat jalan —
 *              lihat catatan di Icd10Seeder untuk detail cakupan.
 * @rollback    Menghapus tabel icd10
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
        Schema::create('icd10', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique();
            $table->string('deskripsi', 255);
            $table->string('kategori', 150)->nullable();
            $table->timestamps();

            $table->index('deskripsi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('icd10');
    }
};
