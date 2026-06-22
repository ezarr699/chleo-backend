<?php
/**
 * ============================================================
 * @module      GolonganDarah
 * @layer       Test > Feature
 * @file        GolonganDarahTest.php
 * @path        Modules/GolonganDarah/Tests/Feature/GolonganDarahTest.php
 * @description Test HTTP endpoint data master Golongan Darah: list/paginate,
 *              create, validasi gagal, duplikat, update, soft delete,
 *              403 tanpa permission, 401 unauthenticated. Ini suite
 *              paling lengkap karena logic CRUD-nya (AbstractMasterData*)
 *              dipakai bersama oleh modul data master lain (mis. JenisKelamin)
 *              — modul lain cukup smoke test karena logic-nya sudah teruji
 *              di sini.
 * @covers      app/Support/MasterData/AbstractMasterDataController.php
 * @covers      app/Support/MasterData/AbstractMasterDataService.php
 * @covers      app/Support/MasterData/AbstractMasterDataRepository.php
 * @covers      Modules/GolonganDarah/Controllers/GolonganDarahController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use App\Models\GolonganDarah;
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

afterEach(function () {
    $this->tenant->delete();
});

it('lists golongan darah paginated', function () {
    $this->asTenant(fn () => GolonganDarah::factory()->count(3)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/golongan-darah')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data', 'meta' => ['current_page', 'per_page', 'total']])
        ->assertJsonCount(3, 'data');
});

it('creates golongan darah successfully', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/golongan-darah', ['name' => 'O'])
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'O');

    $this->asTenant(fn () => expect(GolonganDarah::where('name', 'O')->exists())->toBeTrue());
});

it('returns 422 when name is missing', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/golongan-darah', [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['name']);
});

it('returns 422 when name is a duplicate', function () {
    $this->asTenant(fn () => GolonganDarah::factory()->create(['name' => 'AB']));

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/golongan-darah', ['name' => 'AB'])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['name']);
});

it('updates golongan darah', function () {
    $golonganDarah = $this->asTenant(fn () => GolonganDarah::factory()->create(['name' => 'A']));

    $this->actingAs($this->admin)
        ->putJson("http://acme.localhost/api/v1/golongan-darah/{$golonganDarah->id}", ['name' => 'A+'])
        ->assertStatus(200)
        ->assertJsonPath('data.name', 'A+');
});

it('soft deletes golongan darah', function () {
    $golonganDarah = $this->asTenant(fn () => GolonganDarah::factory()->create());

    $this->actingAs($this->admin)
        ->deleteJson("http://acme.localhost/api/v1/golongan-darah/{$golonganDarah->id}")
        ->assertStatus(200);

    $this->asTenant(fn () => $this->assertSoftDeleted($golonganDarah));
});

it('returns 403 when the user lacks the manage permission', function () {
    $user = $this->asTenant(fn () => User::factory()->create());

    $this->actingAs($user)
        ->postJson('http://acme.localhost/api/v1/golongan-darah', ['name' => 'O'])
        ->assertStatus(403);
});

it('returns 401 when unauthenticated', function () {
    $this->getJson('http://acme.localhost/api/v1/golongan-darah')->assertStatus(401);
});
