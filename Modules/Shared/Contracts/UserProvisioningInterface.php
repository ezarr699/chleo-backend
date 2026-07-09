<?php
/**
 * ============================================================
 * @module      Shared
 * @layer       Contract (Interface)
 * @file        UserProvisioningInterface.php
 * @path        Modules/Shared/Contracts/UserProvisioningInterface.php
 * @description Kontrak untuk membuat/menjamin adanya user admin, dipakai
 *              Modul Tenancy saat provisioning tenant baru (butuh 1 user
 *              admin awal) tanpa mengimpor Model User (Modul Auth)
 *              maupun trait HasRoles milik spatie/laravel-permission
 *              secara langsung. Diikat lewat
 *              Auth\Providers\AuthServiceProvider.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Shared\Contracts;

interface UserProvisioningInterface
{
    /**
     * Idempotent: kalau user dengan email tsb sudah ada, cukup pastikan
     * dia punya role 'admin'; kalau belum ada, buat baru sekaligus
     * assign role 'admin'.
     */
    public function ensureAdminExists(string $name, string $email, string $password): void;
}
