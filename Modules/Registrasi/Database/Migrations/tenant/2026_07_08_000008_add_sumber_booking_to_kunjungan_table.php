<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_08_000008_add_sumber_booking_to_kunjungan_table.php
 * @path        database/migrations/tenant/2026_07_08_000008_add_sumber_booking_to_kunjungan_table.php
 * @description Menambah kolom sumber_booking pada tabel kunjungan
 *              (REG-01-3, Entry Point: Online Booking). Nullable —
 *              hanya diisi untuk cara_masuk='online_booking', menandai
 *              channel booking: 'web_portal' atau 'mobile_jkn'. Tidak
 *              perlu kolom BPJS baru karena numbering online booking
 *              memakai infrastruktur no_registrasi/no_antrian yang
 *              sama dengan walk-in (REG-01-1), dan no_antrian_bpjs/
 *              no_kunjungan_bpjs yang sudah ada dipakai lagi untuk
 *              hasil bridging WSBPJS Antrean.
 * @rollback    Menghapus kolom sumber_booking
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
        Schema::table('kunjungan', function (Blueprint $table) {
            $table->string('sumber_booking', 20)->nullable()->after('cara_masuk');
        });
    }

    public function down(): void
    {
        Schema::table('kunjungan', function (Blueprint $table) {
            $table->dropColumn('sumber_booking');
        });
    }
};
