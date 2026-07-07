<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Test > Feature
 * @file        AgamaTest.php
 * @path        app/Modules/Agama/Tests/Feature/AgamaTest.php
 * @description Smoke test untuk modul Agama — logic CRUD generik
 *              sudah diuji lengkap di
 *              app/Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php.
 * @covers      app/Modules/Agama/Controllers/AgamaController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use App\Models\Agama;
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
