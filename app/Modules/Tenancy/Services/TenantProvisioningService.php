<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Service
 * @file        TenantProvisioningService.php
 * @path        app/Modules/Tenancy/Services/TenantProvisioningService.php
 * @description Business logic provisioning tenant baru: membuat baris
 *              tenant+domain, lalu (via event TenantCreated yang sudah
 *              didaftarkan TenancyServiceProvider) database tenant
 *              otomatis dibuat & dimigrasikan. Service ini juga
 *              men-seed role/permission dan user admin awal (dengan
 *              role "admin") di dalam database tenant baru.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://tenancyforlaravel.com/docs/v3/
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Tenancy\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Modules\Permission\Database\Seeders\RolesAndPermissionsSeeder;
use App\Modules\Tenancy\Contracts\TenantRepositoryInterface;
use App\Modules\Tenancy\Models\Tenant;

final class TenantProvisioningService
{
    public function __construct(
        private readonly TenantRepositoryInterface $tenantRepository,
    ) {}

    /**
     * @param  array<string, mixed>  $admin  ['name' => string, 'email' => string, 'password' => string]
     */
    public function provision(string $slug, array $admin): Tenant
    {
        $tenant = $this->tenantRepository->createWithDomain($slug);

        $tenant->run(function () use ($admin) {
            (new RolesAndPermissionsSeeder())->run();

            $adminUser = User::factory()->create([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => Hash::make($admin['password']),
            ]);

            $adminUser->assignRole('admin');
        });

        return $tenant;
    }
}
