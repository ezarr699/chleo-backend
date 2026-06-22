<?php
/**
 * ============================================================
 * @module      JenisKelamin
 * @layer       Test > Feature
 * @file        JenisKelaminTest.php
 * @path        Modules/JenisKelamin/Tests/Feature/JenisKelaminTest.php
 * @description Smoke test untuk modul JenisKelamin — logic CRUD generik
 *              sudah diuji lengkap di
 *              Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php.
 * @covers      Modules/JenisKelamin/Controllers/JenisKelaminController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use App\Models\JenisKelamin;
use App\Models\User;
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

it('lists jenis kelamin successfully as admin', function () {
    $this->asTenant(fn () => JenisKelamin::factory()->count(2)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/jenis-kelamin')
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

it('creates jenis kelamin successfully as admin', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/jenis-kelamin', ['name' => 'Laki-laki'])
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'Laki-laki');
});
