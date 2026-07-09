<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Test > Feature
 * @file        PoliklinikTest.php
 * @path        Modules/Poliklinik/Tests/Feature/PoliklinikTest.php
 * @description Smoke test untuk modul Poliklinik — logic CRUD generik
 *              sudah diuji lengkap di
 *              app/Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php.
 * @covers      Modules/Poliklinik/Controllers/PoliklinikController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\Poliklinik\Models\Poliklinik;
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

it('lists poliklinik successfully as admin', function () {
    $this->asTenant(fn () => Poliklinik::factory()->count(2)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/poliklinik')
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

it('creates poliklinik successfully as admin', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/poliklinik', ['name' => 'Poli Umum'])
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'Poli Umum');
});
