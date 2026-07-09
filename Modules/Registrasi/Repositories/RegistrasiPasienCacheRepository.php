<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Repository
 * @file        RegistrasiPasienCacheRepository.php
 * @path        Modules/Registrasi/Repositories/RegistrasiPasienCacheRepository.php
 * @description Gerbang query ke registrasi_pasien_cache.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Repositories;

use Modules\Registrasi\Models\RegistrasiPasienCache;

final class RegistrasiPasienCacheRepository
{
    public function upsert(int $pasienId, string $nik, string $nama): RegistrasiPasienCache
    {
        return RegistrasiPasienCache::query()->updateOrCreate(
            ['pasien_id' => $pasienId],
            ['nik' => $nik, 'nama' => $nama, 'synced_at' => now()],
        );
    }

    /**
     * @param  array<int, int>  $pasienIds
     * @return array<int, array{nik: string, nama: string}>
     */
    public function fetchMany(array $pasienIds): array
    {
        $pasienIds = array_values(array_unique($pasienIds));

        if ($pasienIds === []) {
            return [];
        }

        $result = [];
        foreach (RegistrasiPasienCache::query()->whereIn('pasien_id', $pasienIds)->get() as $row) {
            $result[$row->pasien_id] = ['nik' => $row->nik, 'nama' => $row->nama];
        }

        return $result;
    }
}
