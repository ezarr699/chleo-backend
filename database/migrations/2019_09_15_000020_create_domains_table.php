<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Database > Migration (Central)
 * @file        2019_09_15_000020_create_domains_table.php
 * @path        database/migrations/2019_09_15_000020_create_domains_table.php
 * @description Membuat tabel domains di database CENTRAL — pemetaan
 *              hostname (mis. acme.localhost) ke tenant_id.
 * @rollback    Menghapus tabel domains
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domain', 255)->unique();
            $table->string('tenant_id');

            $table->timestamps();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
}
