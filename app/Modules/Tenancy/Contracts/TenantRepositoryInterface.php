<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Contract (Interface)
 * @file        TenantRepositoryInterface.php
 * @path        app/Modules/Tenancy/Contracts/TenantRepositoryInterface.php
 * @description Kontrak untuk implementasi Repository Tenant.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Tenancy\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Modules\Tenancy\Models\Domain;
use App\Modules\Tenancy\Models\Tenant;

interface TenantRepositoryInterface
{
    public function slugExists(string $slug): bool;

    /** @param array<string, mixed> $data */
    public function createWithDomain(string $slug, array $data = []): Tenant;

    /** @return LengthAwarePaginator<int, Tenant> */
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function findById(string $id): ?Tenant;

    public function setSuspended(Tenant $tenant, bool $suspended): Tenant;

    public function delete(Tenant $tenant): void;

    public function addDomain(Tenant $tenant, string $domain): Domain;

    public function removeDomain(Tenant $tenant, int $domainId): void;
}
