<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Database > Migration (Central)
 * @file        2019_09_15_000010_create_tenants_table.php
 * @path        database/migrations/2019_09_15_000010_create_tenants_table.php
 * @description Membuat tabel tenants di database CENTRAL (landlord).
 *              Tabel ini hanya bookkeeping tenant, tidak pernah
 *              menyimpan data bisnis.
 * @rollback    Menghapus tabel tenants
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->string('id')->primary();

            // your custom columns may go here

            $table->timestamps();
            $table->json('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
}
