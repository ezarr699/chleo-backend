<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Database > Migration (Central)
 * @file        2026_06_23_000001_add_suspended_at_to_tenants_table.php
 * @path        database/migrations/2026_06_23_000001_add_suspended_at_to_tenants_table.php
 * @description Menambahkan kolom suspended_at pada tabel tenants
 *              (database central) untuk mendukung suspend/resume tenant
 *              dari aplikasi admin pusat. Null berarti aktif.
 * @rollback    Menghapus kolom suspended_at
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
        Schema::table('tenants', function (Blueprint $table) {
            $table->timestamp('suspended_at')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn('suspended_at');
        });
    }
};
