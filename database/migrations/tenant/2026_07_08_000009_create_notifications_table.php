<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Database > Migration (Tenant)
 * @file        2026_07_08_000009_create_notifications_table.php
 * @path        database/migrations/tenant/2026_07_08_000009_create_notifications_table.php
 * @description Tabel standar Laravel Notification (database channel) —
 *              belum ada di migrations tenant sebelumnya. Dibutuhkan
 *              INT-01-3 (Admin Alert & Notification) supaya notifikasi
 *              in-app error bridging bisa disimpan per tenant, bukan
 *              cuma dikirim ke channel mail. Struktur & nama tabel
 *              ('notifications') mengikuti konvensi bawaan
 *              Illuminate\Notifications\DatabaseNotification, bukan
 *              entity bisnis — sengaja tidak di-Indonesiakan, sama
 *              seperti tabel framework lain (users, cache, jobs).
 * @rollback    Menghapus tabel notifications
 * @since       v1.0.0
 * @ref         https://laravel.com/docs/13.x/notifications#database-notifications
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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
