<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Database > Migration (Central)
 * @file        2026_07_09_000001_add_deleted_at_to_tenants_table.php
 * @path        database/migrations/2026_07_09_000001_add_deleted_at_to_tenants_table.php
 * @description Menambahkan kolom deleted_at pada tabel tenants
 *              (database central) untuk mendukung soft deletes tenant
 *              dari aplikasi admin pusat.
 * @rollback    Menghapus kolom deleted_at
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
            $table->softDeletes()->after('suspended_at');
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
