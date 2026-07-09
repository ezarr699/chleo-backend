<?php
/**
 * ============================================================
 * @module      Billing
 * @layer       Resource
 * @file        InvoiceResource.php
 * @path        Modules/Billing/Resources/InvoiceResource.php
 * @description Transformasi Model Invoice ke format JSON API response.
 *              Controller dilarang mengembalikan Model langsung — semua
 *              response invoice wajib lewat Resource ini.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://laravel.com/docs/13.x/eloquent-resources
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Billing\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class InvoiceResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'pasien_id' => $this->pasien_id,
            'nama_pasien' => $this->nama_pasien_snapshot,
            'no_rm' => $this->no_rm_snapshot,
            'deskripsi_layanan' => $this->deskripsi_layanan,
            'catatan' => $this->catatan,
            'subtotal' => (float) $this->subtotal,
            'pajak' => (float) $this->pajak,
            'total' => (float) $this->total,
            'status' => $this->status,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
