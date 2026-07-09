<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Request
 * @file        UpdateProfilNakesRequest.php
 * @path        Modules/ProfilNakes/Requests/UpdateProfilNakesRequest.php
 * @description Validasi & otorisasi untuk endpoint PUT /profil-nakes/{id}.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\ProfilNakes\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateProfilNakesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('profil_nakes.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required', 'integer', 'exists:users,id',
                Rule::unique('profil_nakes', 'user_id')->ignore((int) $this->route('id')),
            ],
            'profesi_id' => ['required', 'integer', 'exists:profesi,id'],
            'poliklinik_id' => ['nullable', 'integer', 'exists:poliklinik,id'],
            'no_sip' => ['nullable', 'string', 'max:255'],
            'no_str' => ['nullable', 'string', 'max:255'],
            'str_berlaku_sampai' => ['nullable', 'date'],
        ];
    }
}
