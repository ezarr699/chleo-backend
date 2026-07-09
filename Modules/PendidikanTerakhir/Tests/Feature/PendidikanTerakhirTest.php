<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Test > Feature
 * @file        PendidikanTerakhirTest.php
 * @path        Modules/PendidikanTerakhir/Tests/Feature/PendidikanTerakhirTest.php
 * @description Smoke test untuk modul PendidikanTerakhir — logic CRUD generik
 *              sudah diuji lengkap di
 *              app/Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php.
 * @covers      Modules/PendidikanTerakhir/Controllers/PendidikanTerakhirController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\PendidikanTerakhir\Models\PendidikanTerakhir;
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

it('lists pendidikan terakhir successfully as admin', function () {
    $this->asTenant(fn () => PendidikanTerakhir::factory()->count(2)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/pendidikan-terakhir')
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

it('creates pendidikan terakhir successfully as admin', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/pendidikan-terakhir', ['name' => 'SMA'])
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'SMA');
});
