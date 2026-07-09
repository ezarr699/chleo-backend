<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_08_000001_add_kode_bpjs_to_poliklinik_table.php
 * @path        Modules/Poliklinik/Database/Migrations/tenant/2026_07_08_000001_add_kode_bpjs_to_poliklinik_table.php
 * @description Menambah kolom kode_bpjs ke tabel poliklinik — kode
 *              referensi poli versi BPJS (dipakai field `kodepoli` saat
 *              bridging Antrean). Nullable karena tidak semua faskes
 *              langsung punya mapping-nya saat poliklinik dibuat.
 * @rollback    Menghapus kolom kode_bpjs dari tabel poliklinik
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
        Schema::table('poliklinik', function (Blueprint $table) {
            $table->string('kode_bpjs', 10)->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('poliklinik', function (Blueprint $table) {
            $table->dropColumn('kode_bpjs');
        });
    }
};
