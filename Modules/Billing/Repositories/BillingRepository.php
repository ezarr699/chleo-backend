<?php
/**
 * ============================================================
 * @module      Billing
 * @layer       Repository
 * @file        BillingRepository.php
 * @path        Modules/Billing/Repositories/BillingRepository.php
 * @description Gerbang query satu-satunya ke tabel invoice. Tidak ada
 *              method update()/delete() — invoice bersifat immutable
 *              setelah terbit (dokumen finansial), konsisten dengan
 *              Hukum Snapshot Data. Koreksi dilakukan lewat invoice
 *              baru/pembatalan status, bukan mengedit baris lama.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Billing\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Billing\Models\Invoice;

final class BillingRepository
{
    /** @return LengthAwarePaginator<int, Invoice> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Invoice::query()
            ->latest('created_at')
            ->paginate($perPage);
    }

    public function findById(int $id): ?Invoice
    {
        return Invoice::query()->find($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Invoice
    {
        return Invoice::create($data);
    }
}
