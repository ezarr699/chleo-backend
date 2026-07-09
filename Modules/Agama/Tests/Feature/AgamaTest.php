<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Test > Feature
 * @file        AgamaTest.php
 * @path        Modules/Agama/Tests/Feature/AgamaTest.php
 * @description Smoke test untuk modul Agama — logic CRUD generik
 *              sudah diuji lengkap di
 *              Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php.
 * @covers      Modules/Agama/Controllers/AgamaController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\Auth\Models\User;
use Modules\Permission\Database\Seeders\RolesAndPermissionsSeeder;
use Modules\Tenancy\Tests\Concerns\WithTenant;
use Modules\Agama\Models\Agama;

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

it('lists agama successfully as admin', function () {
    $this->asTenant(fn () => Agama::factory()->count(2)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/agama')
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

it('creates agama successfully as admin', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/agama', ['name' => 'Islam'])
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'Islam');
});
