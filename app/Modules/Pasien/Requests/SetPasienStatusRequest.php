<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Request
 * @file        SetPasienStatusRequest.php
 * @path        app/Modules/Pasien/Requests/SetPasienStatusRequest.php
 * @description Validasi untuk endpoint PATCH /pasien/{id}/status.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Pasien\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class SetPasienStatusRequest extends FormRequest
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
            'aktif' => ['required', 'boolean'],
        ];
    }
}
