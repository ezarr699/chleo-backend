<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_08_000003_add_is_bpjs_to_penjamin_table.php
 * @path        Modules/Penjamin/Database/Migrations/tenant/2026_07_08_000003_add_is_bpjs_to_penjamin_table.php
 * @description Menambah kolom is_bpjs ke tabel penjamin — menandai
 *              penjamin mana yang merepresentasikan BPJS Kesehatan.
 *              Dipakai modul Registrasi untuk menentukan apakah sebuah
 *              kunjungan perlu disinkronkan ke bridging BPJS (Antrean/
 *              V-Claim) atau tidak.
 * @rollback    Menghapus kolom is_bpjs dari tabel penjamin
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
        Schema::table('penjamin', function (Blueprint $table) {
            $table->boolean('is_bpjs')->default(false)->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('penjamin', function (Blueprint $table) {
            $table->dropColumn('is_bpjs');
        });
    }
};
