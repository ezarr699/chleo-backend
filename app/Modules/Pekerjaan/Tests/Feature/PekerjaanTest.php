<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Test > Feature
 * @file        PekerjaanTest.php
 * @path        app/Modules/Pekerjaan/Tests/Feature/PekerjaanTest.php
 * @description Smoke test untuk modul Pekerjaan — logic CRUD generik
 *              sudah diuji lengkap di
 *              app/Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php.
 * @covers      app/Modules/Pekerjaan/Controllers/PekerjaanController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use App\Models\Pekerjaan;
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

it('lists pekerjaan successfully as admin', function () {
    $this->asTenant(fn () => Pekerjaan::factory()->count(2)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/pekerjaan')
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

it('creates pekerjaan successfully as admin', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/pekerjaan', ['name' => 'Wiraswasta'])
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'Wiraswasta');
});
