<?php
/**
 * ============================================================
 * @module      StatusPerkawinan
 * @layer       Test > Feature
 * @file        StatusPerkawinanTest.php
 * @path        app/Modules/StatusPerkawinan/Tests/Feature/StatusPerkawinanTest.php
 * @description Smoke test untuk modul StatusPerkawinan — logic CRUD generik
 *              sudah diuji lengkap di
 *              app/Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php.
 * @covers      app/Modules/StatusPerkawinan/Controllers/StatusPerkawinanController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use App\Models\StatusPerkawinan;
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

it('lists status perkawinan successfully as admin', function () {
    $this->asTenant(fn () => StatusPerkawinan::factory()->count(2)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/status-perkawinan')
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

it('creates status perkawinan successfully as admin', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/status-perkawinan', ['name' => 'Menikah'])
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'Menikah');
});
