<?php
/**
 * ============================================================
 * @module      Auth
 * @layer       Provider
 * @file        AuthServiceProvider.php
 * @path        Modules/Auth/Providers/AuthServiceProvider.php
 * @description Bootstrap modul Auth. AuthService type-hint langsung ke
 *              AuthRepository konkret (Contracts/ dihapus). Binding
 *              Shared\Contracts\UserProvisioningInterface dan
 *              AdminNotifierInterface ke UserDirectoryService supaya
 *              Tenancy & IntegrationLog bisa memakai User tanpa
 *              mengimpornya langsung.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Auth\Providers;

use Modules\Auth\Services\UserDirectoryService;
use Modules\BaseServiceProvider;
use Modules\Shared\Contracts\AdminNotifierInterface;
use Modules\Shared\Contracts\UserProvisioningInterface;

final class AuthServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserProvisioningInterface::class, UserDirectoryService::class);
        $this->app->bind(AdminNotifierInterface::class, UserDirectoryService::class);
    }
}
