<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Repository
 * @file        PasienMasterDataCacheRepository.php
 * @path        Modules/Pasien/Repositories/PasienMasterDataCacheRepository.php
 * @description Gerbang query satu-satunya ke tabel pasien_master_data_cache.
 *              upsert() dipanggil SyncMasterDataToPasien setiap kali
 *              MasterDataCreatedOrUpdated diterima. fetchNames() dipakai
 *              PasienService untuk resolusi nama secara batch (index()
 *              daftar pasien) supaya tidak N+1 query per baris.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pasien\Repositories;

use Modules\Pasien\Models\PasienMasterDataCache;

final class PasienMasterDataCacheRepository
{
    public function upsert(string $modul, int $refId, string $nama): PasienMasterDataCache
    {
        return PasienMasterDataCache::query()->updateOrCreate(
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

        $query = PasienMasterDataCache::query()->where(function ($outer) use ($byModul) {
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
