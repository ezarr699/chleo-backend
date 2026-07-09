<?php
/**
 * ============================================================
 * @module      Auth
 * @layer       Test > Feature
 * @file        LoginTest.php
 * @path        Modules/Auth/Tests/Feature/LoginTest.php
 * @description Test HTTP endpoint login: sukses, gagal validasi,
 *              kredensial salah, logout, dan ambil current user.
 *              Setiap test berjalan di dalam konteks tenant ("acme")
 *              karena route Auth sekarang berada di Modules/Auth/Routes/tenant.php
 *              dan hanya bisa diakses lewat subdomain tenant.
 * @covers      Modules/Auth/Controllers/AuthController.php
 * @covers      Modules/Auth/Services/AuthService.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\Auth\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\Tenancy\Tests\Concerns\WithTenant;

uses(WithTenant::class);

beforeEach(function () {
    $this->createTenant('acme');
});

afterEach(function () {
    $this->tenant->delete();
});

it('logs in successfully with valid credentials', function () {
    $user = $this->asTenant(fn () => User::factory()->create([
        'email' => 'budi@example.com',
        'password' => Hash::make('Password123!'),
    ]));

    $response = $this->withHeader('Referer', 'http://acme.localhost:3000')
        ->postJson('http://acme.localhost/api/v1/auth/login', [
            'email' => 'budi@example.com',
            'password' => 'Password123!',
        ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data' => ['id', 'name', 'email']])
        ->assertJsonPath('data.email', $user->email);

    $this->assertAuthenticatedAs($user);
});

it('returns 422 when email is missing', function () {
    $this->postJson('http://acme.localhost/api/v1/auth/login', ['password' => 'Password123!'])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

it('returns 422 when password is missing', function () {
    $this->postJson('http://acme.localhost/api/v1/auth/login', ['email' => 'budi@example.com'])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['password']);
});

it('returns 422 when credentials are wrong', function () {
    $this->asTenant(fn () => User::factory()->create([
        'email' => 'budi@example.com',
        'password' => Hash::make('Password123!'),
    ]));

    $this->postJson('http://acme.localhost/api/v1/auth/login', [
        'email' => 'budi@example.com',
        'password' => 'salah-password',
    ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email']);

    $this->assertGuest();
});

it('returns the authenticated user on /auth/me', function () {
    $user = $this->asTenant(fn () => User::factory()->create());

    $this->actingAs($user)
        ->getJson('http://acme.localhost/api/v1/auth/me')
        ->assertStatus(200)
        ->assertJsonPath('data.email', $user->email);
});

it('returns 401 from /auth/me when unauthenticated', function () {
    $this->getJson('http://acme.localhost/api/v1/auth/me')->assertStatus(401);
});

it('logs out the authenticated user', function () {
    $user = $this->asTenant(fn () => User::factory()->create());

    $this->actingAs($user)
        ->withHeader('Referer', 'http://acme.localhost:3000')
        ->postJson('http://acme.localhost/api/v1/auth/logout')
        ->assertStatus(200);

    $this->assertGuest('web');
});
