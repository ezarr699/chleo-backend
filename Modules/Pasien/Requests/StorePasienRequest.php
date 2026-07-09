<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Request
 * @file        StorePasienRequest.php
 * @path        Modules/Pasien/Requests/StorePasienRequest.php
 * @description Validasi untuk endpoint POST /pasien — hanya 4 field
 *              minimal (nik, nama, tanggal_lahir, jenis_kelamin_id).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pasien\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StorePasienRequest extends FormRequest
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
            'nik' => ['required', 'digits:16', 'unique:pasien,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin_id' => ['required', 'integer', 'exists:jenis_kelamin,id'],
        ];
    }
}
