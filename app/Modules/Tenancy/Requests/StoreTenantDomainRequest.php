<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Request
 * @file        StoreTenantDomainRequest.php
 * @path        app/Modules/Tenancy/Requests/StoreTenantDomainRequest.php
 * @description Validasi untuk endpoint POST /api/v1/tenants/{id}/domains.
 *              Aturan slug sama dengan RegisterTenantRequest karena kolom
 *              `domain` menyimpan fragmen subdomain, bukan FQDN.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Tenancy\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Modules\Tenancy\Contracts\TenantRepositoryInterface;

final class StoreTenantDomainRequest extends FormRequest
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
            'domain' => [
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
        ];
    }
}
