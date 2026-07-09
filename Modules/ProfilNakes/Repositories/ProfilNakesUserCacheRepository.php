<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Repository
 * @file        ProfilNakesUserCacheRepository.php
 * @path        Modules/ProfilNakes/Repositories/ProfilNakesUserCacheRepository.php
 * @description Gerbang query ke profil_nakes_user_cache.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\ProfilNakes\Repositories;

use Modules\ProfilNakes\Models\ProfilNakesUserCache;

final class ProfilNakesUserCacheRepository
{
    public function upsert(int $userId, string $nama, string $email): ProfilNakesUserCache
    {
        return ProfilNakesUserCache::query()->updateOrCreate(
            ['user_id' => $userId],
            ['nama' => $nama, 'email' => $email, 'synced_at' => now()],
        );
    }

    /**
     * @param  array<int, int>  $userIds
     * @return array<int, array{nama: string, email: string}>
     */
    public function fetchMany(array $userIds): array
    {
        $userIds = array_values(array_unique($userIds));

        if ($userIds === []) {
            return [];
        }

        $result = [];
        foreach (ProfilNakesUserCache::query()->whereIn('user_id', $userIds)->get() as $row) {
            $result[$row->user_id] = ['nama' => $row->nama, 'email' => $row->email];
        }

        return $result;
    }
}
