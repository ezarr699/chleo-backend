<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Request
 * @file        BatalRegistrasiRequest.php
 * @path        Modules/Registrasi/Requests/BatalRegistrasiRequest.php
 * @description Validasi untuk endpoint POST /kunjungan/{id}/batal.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class BatalRegistrasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('kunjungan.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'alasan_batal' => ['required', 'string', 'max:255'],
        ];
    }
}
