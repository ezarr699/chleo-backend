<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Service
 * @file        IntegrationLogService.php
 * @path        Modules/IntegrationLog/Services/IntegrationLogService.php
 * @description Business logic dashboard admin (INT-01-2, Resolution
 *              Tracking): list+filter log, dan transisi status_resolusi
 *              open -> investigating -> resolved. Jalur tulis (create
 *              log baru) ada di IntegrationLoggerService, bukan di sini
 *              — Service ini murni sisi baca/resolusi untuk admin. Juga
 *              meresolusi nama resolved_by lewat cache lokal secara
 *              batch supaya index() tidak N+1 query.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\IntegrationLog\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\IntegrationLog\Models\LogIntegrasi;
use Modules\IntegrationLog\Repositories\IntegrationLogRepository;
use Modules\IntegrationLog\Repositories\IntegrationLogUserCacheRepository;

final class IntegrationLogService
{
    public function __construct(
        private readonly IntegrationLogRepository $integrationLogRepository,
        private readonly IntegrationLogUserCacheRepository $userCacheRepository,
    ) {}

    /**
     * @param  array<string, mixed>  $filters
     * @return LengthAwarePaginator<int, LogIntegrasi>
     */
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $paginated = $this->integrationLogRepository->paginate($filters, $perPage);

        $this->attachResolvedByNama($paginated->getCollection());

        return $paginated;
    }

    public function find(int $id): LogIntegrasi
    {
        $log = $this->integrationLogRepository->findById($id);

        abort_if($log === null, 404, 'Log integrasi tidak ditemukan.');

        $this->attachResolvedByNama(collect([$log]));

        return $log;
    }

    public function investigate(int $id): LogIntegrasi
    {
        $log = $this->find($id);

        abort_if($log->status_resolusi !== 'open', 422, 'Log integrasi hanya bisa diinvestigasi dari status open.');

        $log = $this->integrationLogRepository->investigate($log);
        $this->attachResolvedByNama(collect([$log]));

        return $log;
    }

    public function resolve(int $id, string $catatan, int $resolvedBy): LogIntegrasi
    {
        $log = $this->find($id);

        abort_if($log->status_resolusi === 'resolved', 422, 'Log integrasi ini sudah resolved.');

        $log = $this->integrationLogRepository->resolve($log, $catatan, $resolvedBy);
        $this->attachResolvedByNama(collect([$log]));

        return $log;
    }

    /** @param Collection<int, LogIntegrasi> $logs */
    private function attachResolvedByNama(Collection $logs): void
    {
        if ($logs->isEmpty()) {
            return;
        }

        $userIds = $logs->pluck('resolved_by')->filter()->all();
        $names = $this->userCacheRepository->fetchNames($userIds);

        foreach ($logs as $log) {
            $log->setAttribute('resolved_by_nama', $log->resolved_by !== null ? ($names[$log->resolved_by] ?? null) : null);
        }
    }
}
