<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Request
 * @file        UpdatePasienRequest.php
 * @path        Modules/Pasien/Requests/UpdatePasienRequest.php
 * @description Validasi untuk endpoint PUT /pasien/{id} — field dasar
 *              yang sama dengan StorePasienRequest.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pasien\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdatePasienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('pasien.manage') ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'nik' => ['required', 'digits:16', Rule::unique('pasien', 'nik')->ignore((int) $this->route('id'))],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin_id' => ['required', 'integer', 'exists:jenis_kelamin,id'],
        ];
    }
}
