<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Resource
 * @file        TenantResource.php
 * @path        Modules/Tenancy/Resources/TenantResource.php
 * @description Transformasi Model Tenant ke format JSON API response.
 *              Tidak pernah menyertakan kredensial database tenant.
 *              Menyertakan status suspended dan daftar domain untuk
 *              keperluan aplikasi admin pusat.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://laravel.com/docs/13.x/eloquent-resources
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Tenancy\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Tenancy\Models\Domain;

final class TenantResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $domain = $this->domains->first()?->domain;

        return [
            'id' => $this->id,
            'subdomain' => $domain ? $domain.'.'.config('tenancy.central_base_domain') : null,
            'suspended' => $this->suspended_at !== null,
            'domains' => $this->domains->map(fn (Domain $d) => [
                'id' => $d->id,
                'domain' => $d->domain.'.'.config('tenancy.central_base_domain'),
            ])->all(),
            'created_at' => $this->created_at,
        ];
    }
}
