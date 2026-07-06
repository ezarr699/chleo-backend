<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Request
 * @file        RegisterTenantRequest.php
 * @path        app/Modules/Tenancy/Requests/RegisterTenantRequest.php
 * @description Validasi untuk endpoint POST /api/v1/tenants. Otorisasi
 *              endpoint ini ditangani oleh middleware RequireManagementToken
 *              di route, bukan di authorize() — karena ini bukan login user,
 *              melainkan shared secret untuk provisioning internal/admin.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://laravel.com/docs/13.x/validation#form-request-validation
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Tenancy\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Modules\Tenancy\Contracts\TenantRepositoryInterface;

final class RegisterTenantRequest extends FormRequest
{
    private const RESERVED_SLUGS = ['www', 'api', 'admin', 'app', 'demo', 'central', 'localhost'];

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
            'slug' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'regex:/^[a-z0-9-]+$/',
                Rule::notIn(self::RESERVED_SLUGS),
                function (string $attribute, mixed $value, callable $fail) {
                    if (app(TenantRepositoryInterface::class)->slugExists($value)) {
                        $fail('Subdomain sudah digunakan.');
                    }
                },
            ],
            'admin' => ['required', 'array'],
            'admin.name' => ['required', 'string', 'max:255'],
            'admin.email' => ['required', 'email'],
            'admin.password' => ['required', 'string', 'min:8'],
        ];
    }
}
