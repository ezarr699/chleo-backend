<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Test > Feature
 * @file        AsuransiTest.php
 * @path        Modules/Asuransi/Tests/Feature/AsuransiTest.php
 * @description Smoke test untuk modul Asuransi — logic CRUD generik
 *              sudah diuji lengkap di
 *              app/Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php.
 * @covers      Modules/Asuransi/Controllers/AsuransiController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\Asuransi\Models\Asuransi;
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

it('lists asuransi successfully as admin', function () {
    $this->asTenant(fn () => Asuransi::factory()->count(2)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/asuransi')
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

it('creates asuransi successfully as admin', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/asuransi', ['name' => 'Prudential'])
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'Prudential');
});
