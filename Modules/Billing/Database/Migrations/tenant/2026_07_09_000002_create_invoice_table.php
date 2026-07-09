<?php
/**
 * ============================================================
 * @module      Billing
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_09_000002_create_invoice_table.php
 * @path        Modules/Billing/Database/Migrations/tenant/2026_07_09_000002_create_invoice_table.php
 * @description Membuat tabel invoice. subtotal/pajak/total disimpan
 *              sebagai hasil kalkulasi final (bukan dihitung ulang saat
 *              dibaca) — PPN 11% dihitung sekali di BillingService saat
 *              invoice dibuat lalu disimpan apa adanya (Hukum Snapshot).
 *              nama_pasien_snapshot & no_rm_snapshot adalah salinan teks,
 *              bukan hasil join ke tabel pasien. Tabel TENANT — lihat
 *              catatan di migrasi billing_pasien_cache.
 * @rollback    Menghapus tabel invoice
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
        Schema::create('invoice', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('pasien_id');
            $table->string('nama_pasien_snapshot');
            $table->string('no_rm_snapshot')->nullable();
            $table->string('deskripsi_layanan');
            $table->text('catatan')->nullable();
            $table->decimal('subtotal', 15, 2);
            $table->decimal('pajak', 15, 2);
            $table->decimal('total', 15, 2);
            $table->string('status')->default('unpaid');
            $table->timestamps();

            $table->index('pasien_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
