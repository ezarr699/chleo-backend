<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Test > Feature
 * @file        TenantRegistrationTest.php
 * @path        app/Modules/Tenancy/Tests/Feature/TenantRegistrationTest.php
 * @description Test HTTP endpoint POST /api/v1/tenants: sukses,
 *              ditolak tanpa token provisioning, validasi slug
 *              (format, reserved word, duplikat).
 * @covers      app/Modules/Tenancy/Controllers/TenantRegistrationController.php
 * @covers      app/Modules/Tenancy/Services/TenantProvisioningService.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use App\Modules\Tenancy\Models\Tenant;

function validTenantPayload(array $overrides = []): array
{
    return array_merge([
        'slug' => 'acme',
        'admin' => [
            'name' => 'Admin Acme',
            'email' => 'admin@acme.test',
            'password' => 'Password123!',
        ],
    ], $overrides);
}

afterEach(function () {
    Tenant::query()->find('acme')?->delete();
});

it('creates a tenant with a valid provisioning token', function () {
    $this->withHeader('X-Management-Token', config('tenancy.management_token'))
        ->postJson('http://localhost/api/v1/tenants', validTenantPayload())
        ->assertStatus(201)
        ->assertJsonPath('data.subdomain', 'acme.localhost');

    expect(Tenant::query()->find('acme'))->not->toBeNull();
});

it('rejects the request without a provisioning token', function () {
    $this->postJson('http://localhost/api/v1/tenants', validTenantPayload())
        ->assertStatus(403);
});

it('rejects the request with an invalid provisioning token', function () {
    $this->withHeader('X-Management-Token', 'wrong-token')
        ->postJson('http://localhost/api/v1/tenants', validTenantPayload())
        ->assertStatus(403);
});

it('rejects a reserved slug', function () {
    $this->withHeader('X-Management-Token', config('tenancy.management_token'))
        ->postJson('http://localhost/api/v1/tenants', validTenantPayload(['slug' => 'admin']))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['slug']);
});

it('rejects an invalid slug format', function () {
    $this->withHeader('X-Management-Token', config('tenancy.management_token'))
        ->postJson('http://localhost/api/v1/tenants', validTenantPayload(['slug' => 'Not Valid!']))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['slug']);
});

it('rejects a slug that is already taken', function () {
    $this->withHeader('X-Management-Token', config('tenancy.management_token'))
        ->postJson('http://localhost/api/v1/tenants', validTenantPayload())
        ->assertStatus(201);

    $this->withHeader('X-Management-Token', config('tenancy.management_token'))
        ->postJson('http://localhost/api/v1/tenants', validTenantPayload())
        ->assertStatus(422)
        ->assertJsonValidationErrors(['slug']);
});

it('rejects requests made from a tenant subdomain instead of the central domain', function () {
    $this->withHeader('X-Management-Token', config('tenancy.management_token'))
        ->postJson('http://someother.localhost/api/v1/tenants', validTenantPayload())
        ->assertStatus(404);
});
