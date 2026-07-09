<?php
/**
 * ============================================================
 * @module      Shared
 * @layer       Contract (Interface)
 * @file        AdminNotifierInterface.php
 * @path        Modules/Shared/Contracts/AdminNotifierInterface.php
 * @description Kontrak untuk mengirim Notification ke semua user ber-role
 *              admin, dipakai modul lain (mis. IntegrationLog saat level
 *              'error') tanpa perlu query User::role('admin') sendiri —
 *              itu akan memaksa modul lain mengimpor Model User (Modul
 *              Auth) dan mengenal spatie/laravel-permission langsung.
 *              Diikat lewat Auth\Providers\AuthServiceProvider.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Shared\Contracts;

use Illuminate\Notifications\Notification;

interface AdminNotifierInterface
{
    public function notifyAdmins(Notification $notification): void;
}
