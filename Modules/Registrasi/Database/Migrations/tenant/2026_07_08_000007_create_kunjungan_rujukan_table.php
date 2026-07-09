<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_08_000007_create_kunjungan_rujukan_table.php
 * @path        database/migrations/tenant/2026_07_08_000007_create_kunjungan_rujukan_table.php
 * @description Membuat tabel kunjungan_rujukan (REG-01-2, entry point
 *              rujukan Ex/In). 1 kunjungan bisa punya lebih dari satu
 *              baris rujukan (mis. rujukan keluar ditolak, dirujuk ulang
 *              ke faskes lain). arah 'masuk' dibuat bersamaan dengan
 *              Kunjungan baru (cara_masuk='rujukan') lewat
 *              RegistrasiRepository::createRujukanMasuk(). arah 'keluar'
 *              ditempelkan ke Kunjungan yang sudah ada lewat
 *              RegistrasiRepository::rujukKeluar(). nomor_rujukan_sisrute
 *              & nomor_rujukan_bpjs sengaja nullable, sama seperti
 *              no_antrian_bpjs dkk di tabel kunjungan — diisi belakangan
 *              oleh bridging SISRUTE/BPJS (REG-01-2-1/INT-01), bukan oleh
 *              modul ini. Lihat BRIDGING-BPJS-REFERENCE.md untuk detail
 *              field acuan (PCare Kunjungan->rujukan(nomorKunjungan)).
 * @rollback    Menghapus tabel kunjungan_rujukan
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
        Schema::create('kunjungan_rujukan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->constrained('kunjungan')->cascadeOnDelete();

            $table->string('arah', 10);

            $table->string('asal_faskes_kode', 20)->nullable();
            $table->string('asal_faskes_nama', 150)->nullable();
            $table->string('tujuan_faskes_kode', 20)->nullable();
            $table->string('tujuan_faskes_nama', 150)->nullable();

            $table->string('nomor_rujukan_sisrute', 50)->nullable();
            $table->string('nomor_rujukan_bpjs', 50)->nullable();

            $table->string('diagnosa_rujukan', 150)->nullable();
            $table->text('catatan_rujukan')->nullable();
            $table->date('tanggal_rujukan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan_rujukan');
    }
};
