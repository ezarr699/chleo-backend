<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_08_000002_add_kode_bpjs_to_profil_nakes_table.php
 * @path        Modules/ProfilNakes/Database/Migrations/tenant/2026_07_08_000002_add_kode_bpjs_to_profil_nakes_table.php
 * @description Menambah kolom kode_bpjs ke tabel profil_nakes — kode
 *              dokter versi BPJS (dipakai field `kodedokter` saat
 *              bridging Antrean). Nullable, hanya relevan untuk nakes
 *              berprofesi dokter yang praktik di poli BPJS.
 * @rollback    Menghapus kolom kode_bpjs dari tabel profil_nakes
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
        Schema::table('profil_nakes', function (Blueprint $table) {
            $table->string('kode_bpjs', 10)->nullable()->after('no_str');
        });
    }

    public function down(): void
    {
        Schema::table('profil_nakes', function (Blueprint $table) {
            $table->dropColumn('kode_bpjs');
        });
    }
};
