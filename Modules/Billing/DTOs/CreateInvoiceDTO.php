<?php
/**
 * ============================================================
 * @module      Billing
 * @layer       DTO
 * @file        CreateInvoiceDTO.php
 * @path        Modules/Billing/DTOs/CreateInvoiceDTO.php
 * @description Pengunci tipe data input untuk pembuatan Invoice.
 *              fromRequest() HANYA boleh dipanggil setelah Controller
 *              menjalankan validasi HTTP formal ($request->validate()) —
 *              DTO ini tidak memvalidasi, ia hanya mengunci tipe data
 *              yang sudah dinyatakan valid oleh layer sebelumnya (Hukum
 *              Jalur Tunggal: Route -> Controller -> DTO -> Service ->
 *              Repository -> Model).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Billing\DTOs;

use Illuminate\Http\Request;

final readonly class CreateInvoiceDTO
{
    public function __construct(
        public int $pasienId,
        public string $deskripsiLayanan,
        public float $subtotal,
        public ?string $catatan,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            pasienId: $request->integer('pasien_id'),
            deskripsiLayanan: (string) $request->string('deskripsi_layanan'),
            subtotal: (float) $request->input('subtotal'),
            catatan: $request->filled('catatan') ? (string) $request->string('catatan') : null,
        );
    }
}
