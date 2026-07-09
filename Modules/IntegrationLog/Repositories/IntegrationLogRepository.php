<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Repository
 * @file        IntegrationLogRepository.php
 * @path        Modules/IntegrationLog/Repositories/IntegrationLogRepository.php
 * @description Akses data LogIntegrasi: paginate+filter untuk dashboard
 *              admin, dan transisi status_resolusi (open -> investigating
 *              -> resolved). Eager-load resolvedBy dihapus — sudah bukan
 *              relasi Eloquent lagi (Hukum Isolasi Total Eloquent); nama
 *              tampilan diresolusi IntegrationLogService lewat cache lokal.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\IntegrationLog\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\IntegrationLog\Models\LogIntegrasi;

final class IntegrationLogRepository
{
    /**
     * @param  array<string, mixed>  $filters
     * @return LengthAwarePaginator<int, LogIntegrasi>
     */
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return LogIntegrasi::query()
            ->when($filters['integrasi'] ?? null, fn ($q, $v) => $q->where('integrasi', $v))
            ->when($filters['level'] ?? null, fn ($q, $v) => $q->where('level', $v))
            ->when($filters['status_resolusi'] ?? null, fn ($q, $v) => $q->where('status_resolusi', $v))
            ->latest()
            ->paginate($perPage);
    }

    public function findById(int $id): ?LogIntegrasi
    {
        return LogIntegrasi::query()->find($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): LogIntegrasi
    {
        return LogIntegrasi::create($data);
    }

    public function investigate(LogIntegrasi $log): LogIntegrasi
    {
        $log->update(['status_resolusi' => 'investigating']);

        return $log->fresh();
    }

    public function resolve(LogIntegrasi $log, string $catatan, int $resolvedBy): LogIntegrasi
    {
        $log->update([
            'status_resolusi' => 'resolved',
            'catatan_resolusi' => $catatan,
            'resolved_by' => $resolvedBy,
            'resolved_at' => now(),
        ]);

        return $log->fresh();
    }
}
