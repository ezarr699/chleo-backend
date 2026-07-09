<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Test > Feature
 * @file        PenjaminTest.php
 * @path        Modules/Penjamin/Tests/Feature/PenjaminTest.php
 * @description Smoke test untuk modul Penjamin — logic CRUD generik
 *              sudah diuji lengkap di
 *              app/Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php.
 * @covers      Modules/Penjamin/Controllers/PenjaminController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\Penjamin\Models\Penjamin;
use Modules\Auth\Models\User;
use Modules\Permission\Database\Seeders\RolesAndPermissionsSeeder;
use Modules\Tenancy\Tests\Concerns\WithTenant;

uses(WithTenant::class);

beforeEach(function () {
    $this->createTenant('acme');

    $this->admin = $this->asTenant(function () {
        (new RolesAndPermissionsSeeder())->run();

        $user = User::factory()->create();
        $user->assignRole('admin');

        return $user;
    });
});

afterEach(fn () => $this->tenant->delete());

it('lists penjamin successfully as admin', function () {
    $this->asTenant(fn () => Penjamin::factory()->count(2)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/penjamin')
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

it('creates penjamin successfully as admin', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/penjamin', ['name' => 'BPJS Kesehatan'])
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'BPJS Kesehatan');
});
