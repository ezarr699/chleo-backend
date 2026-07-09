<?php
/**
 * ============================================================
 * @module      HubunganKeluarga
 * @layer       Test > Feature
 * @file        HubunganKeluargaTest.php
 * @path        Modules/HubunganKeluarga/Tests/Feature/HubunganKeluargaTest.php
 * @description Smoke test untuk modul HubunganKeluarga — logic CRUD generik
 *              sudah diuji lengkap di
 *              app/Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php.
 * @covers      Modules/HubunganKeluarga/Controllers/HubunganKeluargaController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\HubunganKeluarga\Models\HubunganKeluarga;
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

it('lists hubungan keluarga successfully as admin', function () {
    $this->asTenant(fn () => HubunganKeluarga::factory()->count(2)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/hubungan-keluarga')
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

it('creates hubungan keluarga successfully as admin', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/hubungan-keluarga', ['name' => 'Suami'])
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'Suami');
});
