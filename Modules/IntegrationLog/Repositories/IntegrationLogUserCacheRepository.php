<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Repository
 * @file        IntegrationLogUserCacheRepository.php
 * @path        Modules/IntegrationLog/Repositories/IntegrationLogUserCacheRepository.php
 * @description Gerbang query ke integration_log_user_cache.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\IntegrationLog\Repositories;

use Modules\IntegrationLog\Models\IntegrationLogUserCache;

final class IntegrationLogUserCacheRepository
{
    public function upsert(int $userId, string $nama): IntegrationLogUserCache
    {
        return IntegrationLogUserCache::query()->updateOrCreate(
            ['user_id' => $userId],
            ['nama' => $nama, 'synced_at' => now()],
        );
    }

    /**
     * @param  array<int, int>  $userIds
     * @return array<int, string>
     */
    public function fetchNames(array $userIds): array
    {
        $userIds = array_values(array_unique(array_filter($userIds)));

        if ($userIds === []) {
            return [];
        }

        return IntegrationLogUserCache::query()
            ->whereIn('user_id', $userIds)
            ->pluck('nama', 'user_id')
            ->all();
    }
}
