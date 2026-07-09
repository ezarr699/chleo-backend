<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Database > Migration
 * @file        2026_06_23_231928_drop_asuransi_columns_from_pasien_table.php
 * @description Menghapus kolom asuransi_id/asuransi_nomor_polis/
 *              asuransi_masa_berlaku dari tabel pasien — digantikan
 *              tabel pasien_asuransi (1-ke-banyak) supaya satu pasien
 *              bisa punya lebih dari satu entri asuransi tambahan.
 * @rollback    Mengembalikan 3 kolom asuransi ke tabel pasien
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
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropConstrainedForeignId('asuransi_id');
            $table->dropColumn(['asuransi_nomor_polis', 'asuransi_masa_berlaku']);
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->foreignId('asuransi_id')->nullable()->constrained('asuransi');
            $table->string('asuransi_nomor_polis')->nullable();
            $table->date('asuransi_masa_berlaku')->nullable();
        });
    }
};
