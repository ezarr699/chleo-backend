<?php
/**
 * ============================================================
 * @module      Icd10
 * @layer       Service
 * @file        Icd10Service.php
 * @path        Modules/Icd10/Services/Icd10Service.php
 * @description Business logic Icd10: paginate, search (autocomplete),
 *              create (tambah kode yang belum ada di seed awal).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Icd10\Services;

use Modules\Icd10\Models\Icd10;
use Modules\Icd10\Repositories\Icd10Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

final class Icd10Service
{
    public function __construct(
        private readonly Icd10Repository $icd10Repository,
    ) {}

    /** @return LengthAwarePaginator<int, Icd10> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->icd10Repository->paginate($perPage);
    }

    /** @return Collection<int, Icd10> */
    public function search(string $keyword, int $limit = 20): Collection
    {
        return $this->icd10Repository->search($keyword, $limit);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Icd10
    {
        return $this->icd10Repository->create($data);
    }
}
