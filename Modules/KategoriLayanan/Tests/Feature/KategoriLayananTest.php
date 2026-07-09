<?php
/**
 * ============================================================
 * @module      KategoriLayanan
 * @layer       Test > Feature
 * @file        KategoriLayananTest.php
 * @path        Modules/KategoriLayanan/Tests/Feature/KategoriLayananTest.php
 * @description Smoke test untuk modul KategoriLayanan — logic CRUD generik
 *              sudah diuji lengkap di
 *              app/Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php.
 * @covers      Modules/KategoriLayanan/Controllers/KategoriLayananController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\KategoriLayanan\Models\KategoriLayanan;
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

it('lists kategori layanan successfully as admin', function () {
    $this->asTenant(fn () => KategoriLayanan::factory()->count(2)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/kategori-layanan')
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

it('creates kategori layanan successfully as admin', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/kategori-layanan', ['name' => 'Konsultasi'])
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'Konsultasi');
});
