<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Test > Feature
 * @file        SatuanTest.php
 * @path        Modules/Satuan/Tests/Feature/SatuanTest.php
 * @description Smoke test untuk modul Satuan — logic CRUD generik
 *              sudah diuji lengkap di
 *              app/Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php.
 * @covers      Modules/Satuan/Controllers/SatuanController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\Satuan\Models\Satuan;
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

it('lists satuan successfully as admin', function () {
    $this->asTenant(fn () => Satuan::factory()->count(2)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/satuan')
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

it('creates satuan successfully as admin', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/satuan', ['name' => 'Box'])
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'Box');
});
