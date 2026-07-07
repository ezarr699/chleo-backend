<?php
/**
 * ============================================================
 * @module      KategoriObat
 * @layer       Test > Feature
 * @file        KategoriObatTest.php
 * @path        app/Modules/KategoriObat/Tests/Feature/KategoriObatTest.php
 * @description Smoke test untuk modul KategoriObat — logic CRUD generik
 *              sudah diuji lengkap di
 *              app/Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php.
 * @covers      app/Modules/KategoriObat/Controllers/KategoriObatController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use App\Models\KategoriObat;
use App\Models\User;
use App\Modules\Permission\Database\Seeders\RolesAndPermissionsSeeder;
use App\Modules\Tenancy\Tests\Concerns\WithTenant;

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

it('lists kategori obat successfully as admin', function () {
    $this->asTenant(fn () => KategoriObat::factory()->count(2)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/kategori-obat')
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

it('creates kategori obat successfully as admin', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/kategori-obat', ['name' => 'Generik'])
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'Generik');
});
