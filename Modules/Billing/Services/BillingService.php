<?php
/**
 * ============================================================
 * @module      Billing
 * @layer       Service
 * @file        BillingService.php
 * @path        Modules/Billing/Services/BillingService.php
 * @description Jantung logika bisnis Modul Billing: kalkulasi PPN 11%
 *              sebelum invoice disimpan, dan penerapan Hukum Snapshot
 *              Data (menyalin nama & no_rm dari BillingPasienCache
 *              sebagai teks statis ke invoice, bukan relasi dinamis).
 *              Sengaja HANYA bergantung pada BillingPasienCacheRepository
 *              (replika lokal) — tidak pernah membaca App\Models\Pasien
 *              atau modul Pasien manapun secara langsung, supaya staf/
 *              kode Billing tidak punya jalur teknis untuk menjangkau
 *              data rekam medis pasien.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Billing\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Billing\DTOs\CreateInvoiceDTO;
use Modules\Billing\Models\Invoice;
use Modules\Billing\Repositories\BillingPasienCacheRepository;
use Modules\Billing\Repositories\BillingRepository;

final class BillingService
{
    /** PPN 11% — dihitung sekali saat invoice dibuat, lalu disimpan apa adanya (Hukum Snapshot). */
    private const TARIF_PAJAK = 0.11;

    public function __construct(
        private readonly BillingRepository $billingRepository,
        private readonly BillingPasienCacheRepository $pasienCacheRepository,
    ) {}

    /** @return LengthAwarePaginator<int, Invoice> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->billingRepository->paginate($perPage);
    }

    public function find(int $id): Invoice
    {
        $invoice = $this->billingRepository->findById($id);

        abort_if($invoice === null, 404, 'Invoice tidak ditemukan.');

        return $invoice;
    }

    public function createInvoice(CreateInvoiceDTO $dto): Invoice
    {
        $pasienCache = $this->pasienCacheRepository->findByPasienId($dto->pasienId);

        abort_if(
            $pasienCache === null,
            422,
            'Data pasien belum tersinkron ke modul Billing. Pastikan pasien sudah terdaftar di modul Pasien.',
        );

        $pajak = round($dto->subtotal * self::TARIF_PAJAK, 2);
        $total = round($dto->subtotal + $pajak, 2);

        return $this->billingRepository->create([
            'pasien_id' => $pasienCache->pasien_id,
            'nama_pasien_snapshot' => $pasienCache->nama_lengkap,
            'no_rm_snapshot' => $pasienCache->no_rm,
            'deskripsi_layanan' => $dto->deskripsiLayanan,
            'catatan' => $dto->catatan,
            'subtotal' => $dto->subtotal,
            'pajak' => $pajak,
            'total' => $total,
            'status' => 'unpaid',
        ]);
    }
}
