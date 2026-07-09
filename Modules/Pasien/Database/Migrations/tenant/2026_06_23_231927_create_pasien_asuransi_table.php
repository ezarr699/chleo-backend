<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Database > Migration
 * @file        2026_06_23_231927_create_pasien_asuransi_table.php
 * @description Membuat tabel pasien_asuransi — satu pasien bisa punya
 *              banyak entri asuransi tambahan (asuransi swasta, wajar
 *              lebih dari satu), masing-masing dengan nomor polis & masa
 *              berlaku sendiri. Berbeda dari BPJS yang tetap 1 kolom di
 *              tabel pasien karena secara nyata hanya satu per orang.
 * @rollback    Menghapus tabel pasien_asuransi
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
        Schema::create('pasien_asuransi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            $table->foreignId('asuransi_id')->constrained('asuransi');
            $table->string('nomor_polis')->nullable();
            $table->date('masa_berlaku')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasien_asuransi');
    }
};
