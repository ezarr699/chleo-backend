<?php
/**
 * ============================================================
 * @module      KategoriTriase
 * @layer       Test > Feature
 * @file        KategoriTriaseTest.php
 * @path        Modules/KategoriTriase/Tests/Feature/KategoriTriaseTest.php
 * @description Smoke test untuk modul KategoriTriase — logic CRUD generik
 *              sudah diuji lengkap di
 *              app/Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php.
 * @covers      Modules/KategoriTriase/Controllers/KategoriTriaseController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\KategoriTriase\Models\KategoriTriase;
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

it('lists kategori triase successfully as admin', function () {
    $this->asTenant(fn () => KategoriTriase::factory()->count(2)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/kategori-triase')
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

it('creates kategori triase successfully as admin', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/kategori-triase', ['name' => 'Merah'])
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'Merah');
});
