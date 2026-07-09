<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Service
 * @file        TenantProvisioningService.php
 * @path        Modules/Tenancy/Services/TenantProvisioningService.php
 * @description Business logic provisioning tenant baru: membuat baris
 *              tenant+domain, lalu (via event TenantCreated yang sudah
 *              didaftarkan TenancyServiceProvider) database tenant
 *              otomatis dibuat & dimigrasikan. Service ini juga
 *              men-seed role/permission dan user admin awal (dengan
 *              role "admin") di dalam database tenant baru — lewat
 *              Shared\Contracts\UserProvisioningInterface, BUKAN Model
 *              User langsung (Hukum Isolasi Total Eloquent; Model User
 *              milik Modul Auth).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://tenancyforlaravel.com/docs/v3/
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Tenancy\Services;

use Modules\Icd10\Database\Seeders\Icd10Seeder;
use Modules\Permission\Database\Seeders\RolesAndPermissionsSeeder;
use Modules\Shared\Contracts\UserProvisioningInterface;
use Modules\Tenancy\Models\Tenant;
use Modules\Tenancy\Repositories\TenantRepository;

final class TenantProvisioningService
{
    public function __construct(
        private readonly TenantRepository $tenantRepository,
        private readonly UserProvisioningInterface $userProvisioning,
    ) {}

    /**
     * @param  array<string, mixed>  $admin  ['name' => string, 'email' => string, 'password' => string]
     */
    public function provision(string $slug, array $admin): Tenant
    {
        $tenant = $this->tenantRepository->createWithDomain($slug);

        $tenant->run(function () use ($admin) {
            (new RolesAndPermissionsSeeder())->run();
            (new Icd10Seeder())->run();

            $this->userProvisioning->ensureAdminExists($admin['name'], $admin['email'], $admin['password']);
        });

        return $tenant;
    }
}
