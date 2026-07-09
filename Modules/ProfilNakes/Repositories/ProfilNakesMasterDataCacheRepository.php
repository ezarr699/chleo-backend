<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Repository
 * @file        ProfilNakesMasterDataCacheRepository.php
 * @path        Modules/ProfilNakes/Repositories/ProfilNakesMasterDataCacheRepository.php
 * @description Gerbang query ke profil_nakes_master_data_cache (Profesi,
 *              Poliklinik). Sama persis polanya dengan
 *              Modules/Pasien/Repositories/PasienMasterDataCacheRepository.php.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\ProfilNakes\Repositories;

use Modules\ProfilNakes\Models\ProfilNakesMasterDataCache;

final class ProfilNakesMasterDataCacheRepository
{
    public function upsert(string $modul, int $refId, string $nama): ProfilNakesMasterDataCache
    {
        return ProfilNakesMasterDataCache::query()->updateOrCreate(
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
            $byModul[$ref['modul']][] = $ref['id'];
        }

        if ($byModul === []) {
            return [];
        }

        $query = ProfilNakesMasterDataCache::query()->where(function ($outer) use ($byModul) {
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
