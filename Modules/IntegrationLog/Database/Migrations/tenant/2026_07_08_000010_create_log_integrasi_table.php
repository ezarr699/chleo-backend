<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_08_000010_create_log_integrasi_table.php
 * @path        Modules/IntegrationLog/Database/Migrations/tenant/2026_07_08_000010_create_log_integrasi_table.php
 * @description Membuat tabel log_integrasi (INT-01) — satu baris per
 *              panggilan ke sistem eksternal (BPJS V-Claim/Antrean/
 *              PCare, SISRUTE, SatuSehat FHIR, Analyzer Lab, dsb),
 *              dicatat lewat Contracts/IntegrationLoggerInterface di
 *              Shared/ supaya modul bridging manapun tidak coupled
 *              langsung ke modul IntegrationLog ini. referensi_tipe +
 *              referensi_id menunjuk ke entitas lokal terkait (mis.
 *              kunjungan_rujukan) secara loose (tanpa FK constraint,
 *              karena bisa menunjuk ke tabel berbeda-beda tergantung
 *              integrasi). request_payload/response_payload WAJIB
 *              disanitasi oleh caller sebelum disimpan — jangan pernah
 *              simpan API key/secret/token di kolom ini. resolved_by
 *              SENGAJA tanpa foreign key constraint ke tabel users
 *              (Hukum Isolasi Total Eloquent — Model User milik Modul
 *              Auth) — nama tampilannya diresolusi lewat
 *              integration_log_user_cache.
 * @rollback    Menghapus tabel log_integrasi
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
        Schema::create('log_integrasi', function (Blueprint $table) {
            $table->id();

            $table->string('integrasi', 30);
            $table->string('referensi_tipe', 50)->nullable();
            $table->unsignedBigInteger('referensi_id')->nullable();

            $table->string('endpoint', 255)->nullable();
            $table->string('metode', 10)->nullable();
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->smallInteger('status_code')->nullable();

            $table->string('level', 20)->default('error');
            $table->text('pesan_error')->nullable();

            $table->string('status_resolusi', 20)->default('open');
            $table->text('catatan_resolusi')->nullable();
            $table->unsignedBigInteger('resolved_by')->nullable();
            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();

            $table->index(['integrasi', 'status_resolusi']);
            $table->index(['referensi_tipe', 'referensi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_integrasi');
    }
};
