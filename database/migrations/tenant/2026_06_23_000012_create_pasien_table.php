<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Database > Migration
 * @file        2026_06_23_000012_create_pasien_table.php
 * @description Membuat tabel pasien. Status workflow: belum_verifikasi
 *              (default) -> aktif (otomatis setelah verifikasi) ->
 *              nonaktif (lewat toggle, bisa dibalik tanpa verifikasi ulang).
 *              Field hasil verifikasi (foto, BPJS, asuransi tambahan)
 *              disimpan sebagai kolom nullable langsung di tabel ini —
 *              1-ke-1, opsional, tidak ada kebutuhan query independen.
 * @rollback    Menghapus tabel pasien
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
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('nama', 255);
            $table->date('tanggal_lahir');
            $table->foreignId('jenis_kelamin_id')->constrained('jenis_kelamin');
            $table->string('status', 20)->default('belum_verifikasi');

            $table->string('foto_path')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->foreignId('golongan_darah_id')->nullable()->constrained('golongan_darah');
            $table->string('nomor_telepon', 20)->nullable();
            $table->text('alamat')->nullable();

            $table->string('bpjs_nomor', 50)->nullable();
            $table->string('bpjs_jenis_peserta')->nullable();
            $table->string('bpjs_kelas')->nullable();
            $table->string('bpjs_nama_fasyankes')->nullable();
            $table->string('bpjs_kode_fasyankes')->nullable();
            $table->date('bpjs_masa_berlaku')->nullable();

            $table->foreignId('asuransi_id')->nullable()->constrained('asuransi');
            $table->string('asuransi_nomor_polis')->nullable();
            $table->date('asuransi_masa_berlaku')->nullable();

            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
