<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Request
 * @file        UpdateTenantAdminRequest.php
 * @path        Modules/Tenancy/Requests/UpdateTenantAdminRequest.php
 * @description Validasi untuk endpoint PUT /api/v1/tenants/{id}.
 *              Memperbarui data admin (nama, email, password opsional).
 *              Otorisasi ditangani middleware RequireManagementToken di
 *              route, bukan di authorize().
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Tenancy\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateTenantAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'admin'          => ['required', 'array'],
            'admin.name'     => ['required', 'string', 'max:255'],
            'admin.email'    => ['required', 'email', 'max:255'],
            'admin.password' => ['nullable', 'string', 'min:8'],
        ];
    }
}
