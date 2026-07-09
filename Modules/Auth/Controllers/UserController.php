<?php
/**
 * ============================================================
 * @module      Auth
 * @layer       Controller
 * @file        UserController.php
 * @path        Modules/Auth/Controllers/UserController.php
 * @description Direktori User (read-only) untuk kebutuhan picker di modul
 *              lain (mis. Profil Nakes memilih User yang akan dijadikan
 *              nakes). Digerbangi permission profil_nakes.manage — bukan
 *              endpoint publik semua user terautentikasi, supaya daftar
 *              nama/email staf tidak terekspos ke siapa saja yang login.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Models\User;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Resources\UserListResource;

final class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::query()->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar user berhasil diambil.',
            'data' => UserListResource::collection($users),
        ]);
    }
}
