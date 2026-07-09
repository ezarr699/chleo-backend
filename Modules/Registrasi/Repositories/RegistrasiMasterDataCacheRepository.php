<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Repository
 * @file        RegistrasiMasterDataCacheRepository.php
 * @path        Modules/Registrasi/Repositories/RegistrasiMasterDataCacheRepository.php
 * @description Gerbang query ke registrasi_master_data_cache (Poliklinik,
 *              Penjamin, ProfilNakes, User).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Repositories;

use Modules\Registrasi\Models\RegistrasiMasterDataCache;

final class RegistrasiMasterDataCacheRepository
{
    public function upsert(string $modul, int $refId, string $nama): RegistrasiMasterDataCache
    {
        return RegistrasiMasterDataCache::query()->updateOrCreate(
            ['modul' => $modul, 'ref_id' => $refId],
            ['nama' => $nama, 'synced_at' => now()],
        );
    }

    /**
     * @param  array<int, array{modul: string, id: int}>  $refs
     * @return array<string, string> kunci "{modul}:{id}" => nama
     */
    public function fetchNames(array $refs): array
    {
        $byModul = [];
        foreach ($refs as $ref) {
            if ($ref['id'] === null) {
                continue;
            }
            $byModul[$ref['modul']][] = $ref['id'];
        }

        if ($byModul === []) {
            return [];
        }

        $query = RegistrasiMasterDataCache::query()->where(function ($outer) use ($byModul) {
            foreach ($byModul as $modul => $ids) {
                $outer->orWhere(function ($inner) use ($modul, $ids) {
                    $inner->where('modul', $modul)->whereIn('ref_id', array_unique($ids));
                });
            }
        });

        $result = [];
        foreach ($query->get(['modul', 'ref_id', 'nama']) as $row) {
            $result["{$row->modul}:{$row->ref_id}"] = $row->nama;
        }

        return $result;
    }
}
