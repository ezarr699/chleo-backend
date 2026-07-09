<?php
/**
 * ============================================================
 * @module      Icd10
 * @layer       Repository
 * @file        Icd10Repository.php
 * @path        Modules/Icd10/Repositories/Icd10Repository.php
 * @description Akses data Icd10. search() memakai LIKE 'keyword%' pada
 *              kode & deskripsi (bukan '%keyword%') supaya index yang
 *              sudah dibuat di migration (unique kode, index deskripsi)
 *              tetap kepakai — ini yang bikin autocomplete (RWJ-01-1-1,
 *              target <0.5s) tetap cepat walau data ICD-10 nanti
 *              diperbesar ke katalog WHO penuh (~14.000 kode).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Icd10\Repositories;

use Modules\Icd10\Models\Icd10;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

final class Icd10Repository
{
    /** @return LengthAwarePaginator<int, Icd10> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Icd10::query()->orderBy('kode')->paginate($perPage);
    }

    public function findById(int $id): ?Icd10
    {
        return Icd10::query()->find($id);
    }

    /** @return Collection<int, Icd10> */
    public function search(string $keyword, int $limit = 20): Collection
    {
        $keyword = trim($keyword);

        return Icd10::query()
            ->where(function ($query) use ($keyword) {
                $query->where('kode', 'like', "{$keyword}%")
                    ->orWhere('deskripsi', 'like', "{$keyword}%");
            })
            ->orderBy('kode')
            ->limit($limit)
            ->get();
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Icd10
    {
        return Icd10::create($data);
    }
}
