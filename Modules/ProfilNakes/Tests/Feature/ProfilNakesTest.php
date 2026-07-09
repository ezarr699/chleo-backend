<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Test > Feature
 * @file        ProfilNakesTest.php
 * @path        Modules/ProfilNakes/Tests/Feature/ProfilNakesTest.php
 * @description Test HTTP endpoint ProfilNakes: list, create, validasi FK
 *              (user/profesi/poliklinik harus ada), duplikat user_id
 *              ditolak, update, soft delete, 403, 401. Logic-nya
 *              hand-written (bukan AbstractMasterData*), jadi diuji
 *              penuh di sini, tidak cukup smoke test.
 * @covers      Modules/ProfilNakes/Controllers/ProfilNakesController.php
 * @covers      Modules/ProfilNakes/Services/ProfilNakesService.php
 * @covers      Modules/ProfilNakes/Repositories/ProfilNakesRepository.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\Poliklinik\Models\Poliklinik;
use Modules\Profesi\Models\Profesi;
use Modules\ProfilNakes\Models\ProfilNakes;
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

it('lists profil nakes paginated', function () {
    $this->asTenant(fn () => ProfilNakes::factory()->count(3)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/profil-nakes')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data', 'meta' => ['current_page', 'per_page', 'total']])
        ->assertJsonCount(3, 'data');
});

it('creates profil nakes successfully with valid user, profesi, and poliklinik', function () {
    [$user, $profesi, $poliklinik] = $this->asTenant(fn () => [
        User::factory()->create(),
        Profesi::factory()->create(),
        Poliklinik::factory()->create(),
    ]);

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/profil-nakes', [
            'user_id' => $user->id,
            'profesi_id' => $profesi->id,
            'poliklinik_id' => $poliklinik->id,
            'no_sip' => 'SIP-0001',
            'no_str' => 'STR-0001',
            'str_berlaku_sampai' => '2030-01-01',
        ])
        ->assertStatus(201)
        ->assertJsonPath('data.user.id', $user->id)
        ->assertJsonPath('data.profesi.id', $profesi->id)
        ->assertJsonPath('data.poliklinik.id', $poliklinik->id)
        ->assertJsonPath('data.no_sip', 'SIP-0001');
});

it('creates profil nakes without poliklinik because it is optional', function () {
    [$user, $profesi] = $this->asTenant(fn () => [
        User::factory()->create(),
        Profesi::factory()->create(),
    ]);

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/profil-nakes', [
            'user_id' => $user->id,
            'profesi_id' => $profesi->id,
        ])
        ->assertStatus(201)
        ->assertJsonPath('data.poliklinik', null);
});

it('returns 422 when required fields are missing', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/profil-nakes', [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['user_id', 'profesi_id']);
});

it('returns 422 when user_id does not exist', function () {
    $profesi = $this->asTenant(fn () => Profesi::factory()->create());

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/profil-nakes', [
            'user_id' => 999999,
            'profesi_id' => $profesi->id,
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['user_id']);
});

it('returns 422 when profesi_id does not exist', function () {
    $user = $this->asTenant(fn () => User::factory()->create());

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/profil-nakes', [
            'user_id' => $user->id,
            'profesi_id' => 999999,
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['profesi_id']);
});

it('returns 422 when the user already has a profil nakes', function () {
    $profesi = $this->asTenant(fn () => Profesi::factory()->create());
    $existing = $this->asTenant(fn () => ProfilNakes::factory()->create());

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/profil-nakes', [
            'user_id' => $existing->user_id,
            'profesi_id' => $profesi->id,
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['user_id']);
});

it('updates profil nakes fields', function () {
    $profilNakes = $this->asTenant(fn () => ProfilNakes::factory()->create());
    $newPoliklinik = $this->asTenant(fn () => Poliklinik::factory()->create());

    $this->actingAs($this->admin)
        ->putJson("http://acme.localhost/api/v1/profil-nakes/{$profilNakes->id}", [
            'user_id' => $profilNakes->user_id,
            'profesi_id' => $profilNakes->profesi_id,
            'poliklinik_id' => $newPoliklinik->id,
            'no_sip' => 'SIP-UPDATED',
        ])
        ->assertStatus(200)
        ->assertJsonPath('data.poliklinik.id', $newPoliklinik->id)
        ->assertJsonPath('data.no_sip', 'SIP-UPDATED');
});

it('allows updating profil nakes without changing its own user_id', function () {
    $profilNakes = $this->asTenant(fn () => ProfilNakes::factory()->create());

    $this->actingAs($this->admin)
        ->putJson("http://acme.localhost/api/v1/profil-nakes/{$profilNakes->id}", [
            'user_id' => $profilNakes->user_id,
            'profesi_id' => $profilNakes->profesi_id,
            'no_sip' => 'SIP-SAME-USER',
        ])
        ->assertStatus(200)
        ->assertJsonPath('data.no_sip', 'SIP-SAME-USER');
});

it('soft deletes profil nakes', function () {
    $profilNakes = $this->asTenant(fn () => ProfilNakes::factory()->create());

    $this->actingAs($this->admin)
        ->deleteJson("http://acme.localhost/api/v1/profil-nakes/{$profilNakes->id}")
        ->assertStatus(200);

    $this->asTenant(fn () => $this->assertSoftDeleted($profilNakes));
});

it('returns 403 when the user lacks the manage permission', function () {
    [$user, $profesi] = $this->asTenant(fn () => [
        User::factory()->create(),
        Profesi::factory()->create(),
    ]);
    $unprivileged = $this->asTenant(fn () => User::factory()->create());

    $this->actingAs($unprivileged)
        ->postJson('http://acme.localhost/api/v1/profil-nakes', [
            'user_id' => $user->id,
            'profesi_id' => $profesi->id,
        ])
        ->assertStatus(403);
});

it('returns 401 when unauthenticated', function () {
    $this->getJson('http://acme.localhost/api/v1/profil-nakes')->assertStatus(401);
});
