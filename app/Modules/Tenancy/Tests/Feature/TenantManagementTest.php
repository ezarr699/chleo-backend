<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Test > Feature
 * @file        TenantManagementTest.php
 * @path        app/Modules/Tenancy/Tests/Feature/TenantManagementTest.php
 * @description Test HTTP endpoint manajemen tenant dari aplikasi admin
 *              pusat: list, detail, suspend/resume (dan penegakannya di
 *              tenant route), hapus, domain CRUD, statistik. Semua
 *              digerbangi RequireManagementToken.
 * @covers      app/Modules/Tenancy/Controllers/TenantManagementController.php
 * @covers      app/Modules/Tenancy/Controllers/TenantDomainController.php
 * @covers      app/Modules/Tenancy/Services/TenantManagementService.php
 * @covers      app/Modules/Tenancy/Http/Middleware/EnsureTenantNotSuspended.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use App\Modules\Tenancy\Models\Tenant;

function withManagementToken()
{
    return test()->withHeader('X-Management-Token', config('tenancy.management_token'));
}

afterEach(function () {
    Tenant::query()->find('acme')?->delete();
});

it('rejects tenant management requests without a management token', function () {
    test()->getJson('http://localhost/api/v1/tenants')->assertStatus(403);
});

it('lists tenants with their domains and suspended status', function () {
    withManagementToken()->postJson('http://localhost/api/v1/tenants', [
        'slug' => 'acme',
        'admin' => ['name' => 'Admin Acme', 'email' => 'admin@acme.test', 'password' => 'Password123!'],
    ])->assertStatus(201);

    withManagementToken()->getJson('http://localhost/api/v1/tenants')
        ->assertStatus(200)
        ->assertJsonPath('data.0.id', 'acme')
        ->assertJsonPath('data.0.suspended', false);
});

it('shows a single tenant', function () {
    withManagementToken()->postJson('http://localhost/api/v1/tenants', [
        'slug' => 'acme',
        'admin' => ['name' => 'Admin Acme', 'email' => 'admin@acme.test', 'password' => 'Password123!'],
    ])->assertStatus(201);

    withManagementToken()->getJson('http://localhost/api/v1/tenants/acme')
        ->assertStatus(200)
        ->assertJsonPath('data.subdomain', 'acme.localhost');
});

it('returns 404 for an unknown tenant', function () {
    withManagementToken()->getJson('http://localhost/api/v1/tenants/missing')->assertStatus(404);
});

it('suspends a tenant and that tenant immediately gets blocked on its own subdomain', function () {
    withManagementToken()->postJson('http://localhost/api/v1/tenants', [
        'slug' => 'acme',
        'admin' => ['name' => 'Admin Acme', 'email' => 'admin@acme.test', 'password' => 'Password123!'],
    ])->assertStatus(201);

    withManagementToken()->patchJson('http://localhost/api/v1/tenants/acme', ['suspended' => true])
        ->assertStatus(200)
        ->assertJsonPath('data.suspended', true);

    test()->postJson('http://acme.localhost/api/v1/auth/login', [
        'email' => 'admin@acme.test',
        'password' => 'Password123!',
    ])->assertStatus(403)
        ->assertJsonPath('code', 'tenant_suspended');
});

it('resumes a suspended tenant', function () {
    withManagementToken()->postJson('http://localhost/api/v1/tenants', [
        'slug' => 'acme',
        'admin' => ['name' => 'Admin Acme', 'email' => 'admin@acme.test', 'password' => 'Password123!'],
    ])->assertStatus(201);

    withManagementToken()->patchJson('http://localhost/api/v1/tenants/acme', ['suspended' => true]);

    withManagementToken()->patchJson('http://localhost/api/v1/tenants/acme', ['suspended' => false])
        ->assertStatus(200)
        ->assertJsonPath('data.suspended', false);
});

it('deletes a tenant', function () {
    withManagementToken()->postJson('http://localhost/api/v1/tenants', [
        'slug' => 'acme',
        'admin' => ['name' => 'Admin Acme', 'email' => 'admin@acme.test', 'password' => 'Password123!'],
    ])->assertStatus(201);

    withManagementToken()->deleteJson('http://localhost/api/v1/tenants/acme')->assertStatus(200);

    expect(Tenant::query()->find('acme'))->toBeNull();
});

it('adds and removes a domain for a tenant', function () {
    withManagementToken()->postJson('http://localhost/api/v1/tenants', [
        'slug' => 'acme',
        'admin' => ['name' => 'Admin Acme', 'email' => 'admin@acme.test', 'password' => 'Password123!'],
    ])->assertStatus(201);

    $response = withManagementToken()->postJson('http://localhost/api/v1/tenants/acme/domains', [
        'domain' => 'acme-alt',
    ])->assertStatus(201);

    expect($response->json('data.domains'))->toHaveCount(2);

    $domainId = collect($response->json('data.domains'))
        ->firstWhere('domain', 'acme-alt.localhost')['id'];

    withManagementToken()->deleteJson("http://localhost/api/v1/tenants/acme/domains/{$domainId}")
        ->assertStatus(200)
        ->assertJsonCount(1, 'data.domains');
});

it('returns tenant stats', function () {
    withManagementToken()->postJson('http://localhost/api/v1/tenants', [
        'slug' => 'acme',
        'admin' => ['name' => 'Admin Acme', 'email' => 'admin@acme.test', 'password' => 'Password123!'],
    ])->assertStatus(201);

    withManagementToken()->patchJson('http://localhost/api/v1/tenants/acme', ['suspended' => true]);

    withManagementToken()->getJson('http://localhost/api/v1/tenants/stats')
        ->assertStatus(200)
        ->assertJsonPath('data.suspended', 1);
});
