<?php
/**
 * ============================================================
 * @module      Profesi
 * @layer       Test > Feature
 * @file        ProfesiTest.php
 * @path        app/Modules/Profesi/Tests/Feature/ProfesiTest.php
 * @description Smoke test untuk modul Profesi — logic CRUD generik
 *              sudah diuji lengkap di
 *              app/Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php.
 * @covers      app/Modules/Profesi/Controllers/ProfesiController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use App\Models\Profesi;
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

it('lists profesi successfully as admin', function () {
    $this->asTenant(fn () => Profesi::factory()->count(2)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/profesi')
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

it('creates profesi successfully as admin', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/profesi', ['name' => 'Dokter Umum'])
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'Dokter Umum');
});
