<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Test > Unit
 * @file        TenantProvisioningServiceTest.php
 * @path        app/Modules/Tenancy/Tests/Unit/TenantProvisioningServiceTest.php
 * @description Unit test untuk TenantProvisioningService::provision.
 * @covers      app/Modules/Tenancy/Services/TenantProvisioningService.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use App\Modules\Tenancy\Contracts\TenantRepositoryInterface;
use App\Modules\Tenancy\Models\Tenant;
use App\Modules\Tenancy\Services\TenantProvisioningService;

it('creates the tenant and runs the admin-seeding callback inside the tenant context', function () {
    // The closure is only asserted to be callable, not executed — executing it
    // would hit the real `users` table, which doesn't exist on the central
    // connection a Unit test runs against (database-per-tenant).
    $tenant = Mockery::mock(Tenant::class);
    $tenant->shouldReceive('run')->once()->with(Mockery::on(fn ($callback) => is_callable($callback)));

    $repository = Mockery::mock(TenantRepositoryInterface::class);
    $repository->shouldReceive('createWithDomain')
        ->once()
        ->with('acme')
        ->andReturn($tenant);

    $service = new TenantProvisioningService($repository);

    $result = $service->provision('acme', [
        'name' => 'Admin Acme',
        'email' => 'admin@acme.test',
        'password' => 'Password123!',
    ]);

    expect($result)->toBe($tenant);
});
