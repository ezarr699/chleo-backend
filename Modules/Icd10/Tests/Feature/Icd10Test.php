<?php
/**
 * ============================================================
 * @module      Icd10
 * @layer       Test > Feature
 * @file        Icd10Test.php
 * @path        Modules/Icd10/Tests/Feature/Icd10Test.php
 * @description Test HTTP endpoint Icd10: search/autocomplete
 *              (RWJ-01-1-1), list paginated, create, validasi gagal,
 *              permission (icd10.view vs icd10.manage), 401/403.
 * @covers      Modules/Icd10/Controllers/Icd10Controller.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\Icd10\Models\Icd10;
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

afterEach(function () {
    $this->tenant->delete();
});

it('searches icd10 by kode prefix', function () {
    $this->asTenant(function () {
        Icd10::factory()->create(['kode' => 'J00', 'deskripsi' => 'Nasofaringitis akut']);
        Icd10::factory()->create(['kode' => 'J02.9', 'deskripsi' => 'Faringitis akut']);
        Icd10::factory()->create(['kode' => 'K30', 'deskripsi' => 'Dispepsia']);
    });

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/icd10/search?keyword=J0')
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

it('searches icd10 by deskripsi prefix', function () {
    $this->asTenant(fn () => Icd10::factory()->create(['kode' => 'I10', 'deskripsi' => 'Hipertensi esensial']));

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/icd10/search?keyword=Hipertensi')
        ->assertStatus(200)
        ->assertJsonPath('data.0.kode', 'I10');
});

it('returns 422 when search keyword is too short', function () {
    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/icd10/search?keyword=J')
        ->assertStatus(422)
        ->assertJsonValidationErrors(['keyword']);
});

it('lists icd10 paginated', function () {
    $this->asTenant(fn () => Icd10::factory()->count(3)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/icd10')
        ->assertStatus(200)
        ->assertJsonCount(3, 'data');
});

it('creates a new icd10 code', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/icd10', [
            'kode' => 'A00',
            'deskripsi' => 'Kolera',
            'kategori' => 'Penyakit infeksi & parasit',
        ])
        ->assertStatus(201)
        ->assertJsonPath('data.kode', 'A00');
});

it('returns 422 when creating a duplicate kode', function () {
    $this->asTenant(fn () => Icd10::factory()->create(['kode' => 'A00']));

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/icd10', [
            'kode' => 'A00',
            'deskripsi' => 'Kolera duplikat',
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['kode']);
});

it('returns 403 when the user lacks the manage permission', function () {
    $user = $this->asTenant(fn () => User::factory()->create());

    $this->actingAs($user)
        ->postJson('http://acme.localhost/api/v1/icd10', [
            'kode' => 'A00',
            'deskripsi' => 'Kolera',
        ])
        ->assertStatus(403);
});

it('returns 401 when unauthenticated', function () {
    $this->getJson('http://acme.localhost/api/v1/icd10')->assertStatus(401);
});
