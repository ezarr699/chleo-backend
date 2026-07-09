<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Test > Unit
 * @file        TenantProvisioningServiceTest.php
 * @path        Modules/Tenancy/Tests/Unit/TenantProvisioningServiceTest.php
 * @description Unit test untuk TenantProvisioningService::provision.
 * @covers      Modules/Tenancy/Services/TenantProvisioningService.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\Tenancy\Models\Tenant;
use Modules\Tenancy\Repositories\TenantRepository;
use Modules\Tenancy\Services\TenantProvisioningService;
use Modules\Shared\Contracts\UserProvisioningInterface;

it('creates the tenant and runs the admin-seeding callback inside the tenant context', function () {
    // The closure is only asserted to be callable, not executed — executing it
    // would hit the real `users` table, which doesn't exist on the central
    // connection a Unit test runs against (database-per-tenant). Because the
    // closure never runs, $userProvisioning->ensureAdminExists() inside it is
    // never actually invoked either — the mock only needs to exist to satisfy
    // the constructor.
    $tenant = Mockery::mock(Tenant::class);
    $tenant->shouldReceive('run')->once()->with(Mockery::on(fn ($callback) => is_callable($callback)));

    $repository = Mockery::mock(TenantRepository::class);
    $repository->shouldReceive('createWithDomain')
        ->once()
        ->with('acme')
        ->andReturn($tenant);

    $userProvisioning = Mockery::mock(UserProvisioningInterface::class);

    $service = new TenantProvisioningService($repository, $userProvisioning);

    $result = $service->provision('acme', [
        'name' => 'Admin Acme',
        'email' => 'admin@acme.test',
        'password' => 'Password123!',
    ]);

    expect($result)->toBe($tenant);
});
