<?php
/**
 * ============================================================
 * @module      Auth
 * @layer       Resource
 * @file        UserListResource.php
 * @path        Modules/Auth/Resources/UserListResource.php
 * @description Transformasi Model User untuk endpoint direktori user
 *              (GET /users) — dipakai picker Profil Nakes. Sengaja tipis
 *              (id/name/email saja, tanpa permissions) beda dari
 *              UserResource yang khusus untuk sesi user yang sedang login.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class UserListResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
