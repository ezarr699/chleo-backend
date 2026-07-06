<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Repository
 * @file        TenantRepository.php
 * @path        app/Modules/Tenancy/Repositories/TenantRepository.php
 * @description Akses data Tenant & Domain di database central.
 *              PENTING: kolom `domain` menyimpan SLUG subdomain saja
 *              (mis. "acme"), bukan full hostname ("acme.localhost") —
 *              karena Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain
 *              mencocokkan hanya fragmen pertama hostname terhadap
 *              kolom ini (lihat makeSubdomain() di middleware tersebut).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Tenancy\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Modules\Tenancy\Contracts\TenantRepositoryInterface;
use App\Modules\Tenancy\Models\Domain;
use App\Modules\Tenancy\Models\Tenant;

final class TenantRepository implements TenantRepositoryInterface
{
    public function slugExists(string $slug): bool
    {
        return Domain::where('domain', $slug)->exists();
    }

    /** @param array<string, mixed> $data */
    public function createWithDomain(string $slug, array $data = []): Tenant
    {
        $tenant = Tenant::create(['id' => $slug, ...$data]);

        $tenant->domains()->create(['domain' => $slug]);

        return $tenant;
    }

    /** @return LengthAwarePaginator<int, Tenant> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Tenant::query()->with('domains')->latest('created_at')->paginate($perPage);
    }

    public function findById(string $id): ?Tenant
    {
        return Tenant::query()->with('domains')->find($id);
    }

    public function setSuspended(Tenant $tenant, bool $suspended): Tenant
    {
        $tenant->suspended_at = $suspended ? now() : null;
        $tenant->save();

        return $tenant;
    }

    public function delete(Tenant $tenant): void
    {
        $tenant->delete();
    }

    public function addDomain(Tenant $tenant, string $domain): Domain
    {
        return $tenant->domains()->create(['domain' => $domain]);
    }

    public function removeDomain(Tenant $tenant, int $domainId): void
    {
        $tenant->domains()->where('id', $domainId)->delete();
    }
}
