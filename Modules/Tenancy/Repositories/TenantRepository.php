<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Repository
 * @file        TenantRepository.php
 * @path        Modules/Tenancy/Repositories/TenantRepository.php
 * @description Akses data Tenant & Domain di database central.
 *              PENTING: kolom `domain` menyimpan SLUG subdomain saja
 *              (mis. "acme"), bukan full hostname ("acme.localhost") —
 *              karena Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain
 *              mencocokkan hanya fragmen pertama hostname terhadap
 *              kolom ini (lihat makeSubdomain() di middleware tersebut).
 *              Sengaja TIDAK final — Tests/Unit/TenantProvisioningServiceTest.php
 *              mem-Mockery::mock() class ini langsung (tanpa interface),
 *              dan Mockery butuh bisa extends class tsb untuk membuat mock.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Tenancy\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Tenancy\Models\Domain;
use Modules\Tenancy\Models\Tenant;

class TenantRepository
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
    public function paginate(int $perPage = 15, ?string $status = null, ?string $sortOrder = 'desc'): LengthAwarePaginator
    {
        $query = Tenant::query()->with('domains');

        if ($status === 'deleted') {
            $query = Tenant::onlyTrashed()->with('domains');
        } elseif ($status === 'aktif') {
            $query->whereNull('suspended_at');
        } elseif ($status === 'ditangguhkan') {
            $query->whereNotNull('suspended_at');
        }

        $order = strtolower($sortOrder ?? 'desc') === 'asc' ? 'asc' : 'desc';
        $query->orderBy('created_at', $order);

        return $query->paginate($perPage);
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

    public function restore(string $id): Tenant
    {
        /** @var Tenant $tenant */
        $tenant = Tenant::withTrashed()->with('domains')->findOrFail($id);
        $tenant->restore();

        return $tenant->fresh('domains');
    }

    /**
     * @param  array{name?: string, email?: string, password?: string}  $admin
     */
    public function updateAdminDetails(Tenant $tenant, array $admin): Tenant
    {
        if (isset($admin['name']))  $tenant->name  = $admin['name'];
        if (isset($admin['email'])) $tenant->email = $admin['email'];
        if (!empty($admin['password'])) {
            $tenant->password = bcrypt($admin['password']);
        }
        $tenant->save();

        return $tenant->fresh('domains');
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
