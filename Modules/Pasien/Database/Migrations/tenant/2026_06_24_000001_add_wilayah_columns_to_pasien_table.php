<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Database > Migration
 * @file        2026_06_24_000001_add_wilayah_columns_to_pasien_table.php
 * @description Menambah kolom wilayah administratif (provinsi, kabupaten/
 *              kota, kecamatan, kelurahan) ke tabel pasien. Kode wilayah
 *              merujuk ke data referensi laravolt/indonesia yang disimpan
 *              di database central (lihat App\Models\Provinsi dkk.) —
 *              bukan foreign key SQL karena beda database, validasi
 *              keberadaannya dilakukan di VerifyPasienRequest.
 * @rollback    Menghapus kolom provinsi_code, kabupaten_code, kecamatan_code,
 *              kelurahan_code dari tabel pasien
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
            $table->char('provinsi_code', 2)->nullable()->after('alamat');
            $table->char('kabupaten_code', 4)->nullable()->after('provinsi_code');
            $table->char('kecamatan_code', 7)->nullable()->after('kabupaten_code');
            $table->char('kelurahan_code', 10)->nullable()->after('kecamatan_code');
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn(['provinsi_code', 'kabupaten_code', 'kecamatan_code', 'kelurahan_code']);
        });
    }
};
