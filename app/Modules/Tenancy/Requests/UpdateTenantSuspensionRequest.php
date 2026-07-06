<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Request
 * @file        UpdateTenantSuspensionRequest.php
 * @path        app/Modules/Tenancy/Requests/UpdateTenantSuspensionRequest.php
 * @description Validasi untuk endpoint PATCH /api/v1/tenants/{id}.
 *              Otorisasi ditangani middleware RequireManagementToken di
 *              route, bukan di authorize().
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Tenancy\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateTenantSuspensionRequest extends FormRequest
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
            'suspended' => ['required', 'boolean'],
        ];
    }
}
