<?php
/**
 * ============================================================
 * @module      Auth
 * @layer       Repository
 * @file        AuthRepository.php
 * @path        Modules/Auth/Repositories/AuthRepository.php
 * @description Akses data User untuk kebutuhan autentikasi. Sengaja TIDAK
 *              final — Modules/Auth/Tests/Unit/AuthServiceTest.php
 *              mem-Mockery::mock() class ini langsung (tanpa interface),
 *              dan Mockery butuh bisa extends class tsb untuk membuat mock.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\Auth\Repositories;

use Modules\Auth\Models\User;

class AuthRepository
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
