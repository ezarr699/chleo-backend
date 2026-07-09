<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_08_000006_create_kunjungan_table.php
 * @path        database/migrations/tenant/2026_07_08_000006_create_kunjungan_table.php
 * @description Membuat tabel kunjungan — 1 baris per kedatangan pasien
 *              (berbeda dari tabel pasien yang 1 baris per orang seumur
 *              hidup). no_registrasi & no_antrian/angka_antrian dibuat
 *              lokal lewat RegistrasiRepository (lihat tabel
 *              urutan_registrasi_harian & urutan_antrian_poliklinik).
 *              no_antrian_bpjs, no_kunjungan_bpjs, dan no_sep sengaja
 *              nullable — diisi belakangan oleh proses bridging BPJS
 *              (WSBPJS/PCare/V-Claim, domain JKN-01-2 & INT-01), bukan
 *              oleh modul Registrasi ini.
 * @rollback    Menghapus tabel kunjungan
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
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien');
            $table->foreignId('poliklinik_id')->constrained('poliklinik');
            $table->foreignId('profil_nakes_id')->nullable()->constrained('profil_nakes')->nullOnDelete();
            $table->foreignId('penjamin_id')->constrained('penjamin');
            $table->string('cara_masuk', 30)->default('walk_in');
            $table->date('tanggal_kunjungan');
            $table->string('jam_praktek', 20)->nullable();

            $table->unsignedInteger('urutan_harian');
            $table->string('no_registrasi', 30)->unique();

            $table->unsignedInteger('angka_antrian');
            $table->string('no_antrian', 20);

            $table->string('no_antrian_bpjs', 50)->nullable();
            $table->string('no_kunjungan_bpjs', 50)->nullable();
            $table->string('no_sep', 50)->nullable()->unique();

            $table->string('status', 20)->default('menunggu');
            $table->string('alasan_batal')->nullable();
            $table->text('catatan')->nullable();

            $table->foreignId('registered_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tanggal_kunjungan', 'poliklinik_id', 'angka_antrian']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};
