<?php
/**
 * ============================================================
 * @module      RawatJalan
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_08_000012_create_pemeriksaan_table.php
 * @path        Modules/RawatJalan/Database/Migrations/tenant/2026_07_08_000012_create_pemeriksaan_table.php
 * @description Membuat tabel pemeriksaan (RWJ-01-1) — form SOAP
 *              (Subjective, Objective, Assessment, Plan) untuk satu
 *              kunjungan rawat jalan. 1:1 ke kunjungan (unique
 *              kunjungan_id) karena satu kunjungan = satu episode
 *              pemeriksaan. Assessment (diagnosis ICD-10) ada di tabel
 *              terpisah pemeriksaan_diagnosis (many-to-one), bukan
 *              kolom di sini, karena satu pemeriksaan bisa punya
 *              diagnosis utama + beberapa sekunder. kunjungan_id/
 *              profil_nakes_id SENGAJA tanpa foreign key constraint ke
 *              tabel kunjungan/profil_nakes (Hukum Isolasi Total Eloquent
 *              berlaku di level skema juga — modul RawatJalan tidak boleh
 *              hard-coupled ke skema Modul Registrasi/ProfilNakes).
 *              nama_nakes_snapshot = salinan teks nama nakes (Hukum
 *              Snapshot Data) diambil saat pemeriksaan dicatat.
 * @rollback    Menghapus tabel pemeriksaan
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
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kunjungan_id')->unique();
            $table->unsignedBigInteger('profil_nakes_id');
            $table->string('nama_nakes_snapshot')->nullable();

            $table->text('subjektif')->nullable();

            $table->unsignedSmallInteger('tekanan_darah_sistolik')->nullable();
            $table->unsignedSmallInteger('tekanan_darah_diastolik')->nullable();
            $table->unsignedSmallInteger('nadi')->nullable();
            $table->decimal('suhu', 4, 1)->nullable();
            $table->unsignedSmallInteger('pernapasan')->nullable();
            $table->unsignedSmallInteger('saturasi_oksigen')->nullable();
            $table->decimal('tinggi_badan', 5, 1)->nullable();
            $table->decimal('berat_badan', 5, 1)->nullable();
            $table->text('objektif_lainnya')->nullable();

            $table->text('rencana')->nullable();

            $table->timestamp('diperiksa_pada')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan');
    }
};
