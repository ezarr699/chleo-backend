<?php
/**
 * ============================================================
 * @module      Auth
 * @layer       Test > Feature
 * @file        UserListTest.php
 * @path        Modules/Auth/Tests/Feature/UserListTest.php
 * @description Test HTTP endpoint GET /users (direktori user untuk picker
 *              Profil Nakes): sukses, 403 tanpa permission profil_nakes.manage,
 *              401 unauthenticated.
 * @covers      Modules/Auth/Controllers/UserController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

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

it('lists users for admin with profil_nakes.manage permission', function () {
    $this->asTenant(fn () => User::factory()->count(2)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/users')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data' => [['id', 'name', 'email']]])
        ->assertJsonCount(3, 'data'); // 2 baru + admin sendiri
});

it('returns 403 when the user lacks profil_nakes.manage permission', function () {
    $user = $this->asTenant(fn () => User::factory()->create());

    $this->actingAs($user)
        ->getJson('http://acme.localhost/api/v1/users')
        ->assertStatus(403);
});

it('returns 401 when unauthenticated', function () {
    $this->getJson('http://acme.localhost/api/v1/users')->assertStatus(401);
});
