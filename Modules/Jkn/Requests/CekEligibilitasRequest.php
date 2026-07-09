<?php
/**
 * ============================================================
 * @module      Jkn
 * @layer       Request
 * @file        CekEligibilitasRequest.php
 * @path        Modules/Jkn/Requests/CekEligibilitasRequest.php
 * @description Validasi untuk endpoint GET /bpjs/peserta (cek
 *              eligibilitas peserta BPJS sebelum buat SEP).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Jkn\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class CekEligibilitasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('bpjs_vclaim.view') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'no_kartu' => ['required', 'string', 'max:20'],
            'tanggal_sep' => ['required', 'date'],
        ];
    }
}
