<?php
/**
 * ============================================================
 * @module      Auth
 * @layer       Test > Unit
 * @file        AuthServiceTest.php
 * @path        Modules/Auth/Tests/Unit/AuthServiceTest.php
 * @description Unit test untuk AuthService::attempt.
 * @covers      Modules/Auth/Services/AuthService.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\Auth\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Repositories\AuthRepository;
use Modules\Auth\Services\AuthService;

beforeEach(function () {
    $this->repository = Mockery::mock(AuthRepository::class);
    $this->service = new AuthService($this->repository);
});

it('returns the user when credentials are valid', function () {
    $user = User::factory()->make([
        'email' => 'budi@example.com',
        'password' => Hash::make('Password123!'),
    ]);

    $this->repository
        ->shouldReceive('findByEmail')
        ->once()
        ->with('budi@example.com')
        ->andReturn($user);

    $result = $this->service->attempt('budi@example.com', 'Password123!');

    expect($result)->toBe($user);
});

it('throws a validation exception when the user does not exist', function () {
    $this->repository
        ->shouldReceive('findByEmail')
        ->once()
        ->with('tidak-ada@example.com')
        ->andReturn(null);

    $this->service->attempt('tidak-ada@example.com', 'Password123!');
})->throws(ValidationException::class);

it('throws a validation exception when the password is wrong', function () {
    $user = User::factory()->make([
        'email' => 'budi@example.com',
        'password' => Hash::make('Password123!'),
    ]);

    $this->repository
        ->shouldReceive('findByEmail')
        ->once()
        ->with('budi@example.com')
        ->andReturn($user);

    $this->service->attempt('budi@example.com', 'password-salah');
})->throws(ValidationException::class);
