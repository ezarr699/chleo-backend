<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Request
 * @file        StoreProfilNakesRequest.php
 * @path        app/Modules/ProfilNakes/Requests/StoreProfilNakesRequest.php
 * @description Validasi & otorisasi untuk endpoint POST /profil-nakes.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\ProfilNakes\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreProfilNakesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('profil_nakes.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id', 'unique:profil_nakes,user_id'],
            'profesi_id' => ['required', 'integer', 'exists:profesi,id'],
            'poliklinik_id' => ['nullable', 'integer', 'exists:poliklinik,id'],
            'no_sip' => ['nullable', 'string', 'max:255'],
            'no_str' => ['nullable', 'string', 'max:255'],
            'str_berlaku_sampai' => ['nullable', 'date'],
        ];
    }
}
