<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Service
 * @file        TenantManagementService.php
 * @path        Modules/Tenancy/Services/TenantManagementService.php
 * @description Business logic untuk pengelolaan tenant dari aplikasi
 *              admin pusat: list, detail, suspend/resume, hapus, dan
 *              manajemen domain. Provisioning (pembuatan tenant baru)
 *              tetap ditangani TenantProvisioningService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Tenancy\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Tenancy\Contracts\TenantRepositoryInterface;
use Modules\Tenancy\Models\Domain;
use Modules\Tenancy\Models\Tenant;

final class TenantManagementService
{
    public function __construct(
        private readonly TenantRepositoryInterface $tenantRepository,
    ) {}

    /** @return LengthAwarePaginator<int, Tenant> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->tenantRepository->paginate($perPage);
    }

    public function find(string $id): Tenant
    {
        $tenant = $this->tenantRepository->findById($id);

        abort_if($tenant === null, 404, 'Tenant tidak ditemukan.');

        return $tenant;
    }

    public function setSuspended(string $id, bool $suspended): Tenant
    {
        return $this->tenantRepository->setSuspended($this->find($id), $suspended);
    }

    public function delete(string $id): void
    {
        $this->tenantRepository->delete($this->find($id));
    }

    public function addDomain(string $tenantId, string $domain): Domain
    {
        return $this->tenantRepository->addDomain($this->find($tenantId), $domain);
    }

    public function removeDomain(string $tenantId, int $domainId): void
    {
        $this->tenantRepository->removeDomain($this->find($tenantId), $domainId);
    }

    /** @return array{total: int, active: int, suspended: int} */
    public function stats(): array
    {
        $total = Tenant::query()->count();
        $suspended = Tenant::query()->whereNotNull('suspended_at')->count();

        return [
            'total' => $total,
            'active' => $total - $suspended,
            'suspended' => $suspended,
        ];
    }
}
