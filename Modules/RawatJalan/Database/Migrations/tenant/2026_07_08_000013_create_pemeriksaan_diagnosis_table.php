<?php
/**
 * ============================================================
 * @module      RawatJalan
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_08_000013_create_pemeriksaan_diagnosis_table.php
 * @path        Modules/RawatJalan/Database/Migrations/tenant/2026_07_08_000013_create_pemeriksaan_diagnosis_table.php
 * @description Membuat tabel pemeriksaan_diagnosis (bagian Assessment
 *              dari RWJ-01-1) — diagnosis ICD-10 yang menempel ke satu
 *              pemeriksaan. tipe 'utama'/'sekunder'; aturan hanya boleh
 *              ada satu 'utama' per pemeriksaan dijaga di
 *              RawatJalanService, bukan constraint DB (partial unique
 *              index butuh generated column di MySQL, tidak sepadan
 *              untuk aturan sesederhana ini). pemeriksaan_id tetap pakai
 *              foreign key constraint (sama-sama milik Modul RawatJalan,
 *              bukan lintas modul). icd10_id SENGAJA tanpa constrained()
 *              ke tabel icd10 (Hukum Isolasi Total Eloquent — Modul Icd10
 *              beda modul). icd10_kode_snapshot/icd10_deskripsi_snapshot
 *              = salinan teks (Hukum Snapshot Data) diambil saat
 *              diagnosis dicatat.
 * @rollback    Menghapus tabel pemeriksaan_diagnosis
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
        Schema::create('pemeriksaan_diagnosis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemeriksaan_id')->constrained('pemeriksaan')->cascadeOnDelete();
            $table->unsignedBigInteger('icd10_id');
            $table->string('icd10_kode_snapshot')->nullable();
            $table->string('icd10_deskripsi_snapshot')->nullable();
            $table->string('tipe', 20)->default('sekunder');
            $table->string('catatan', 255)->nullable();
            $table->timestamps();

            $table->unique(['pemeriksaan_id', 'icd10_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_diagnosis');
    }
};
