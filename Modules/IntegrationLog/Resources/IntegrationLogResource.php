<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Resource
 * @file        IntegrationLogResource.php
 * @path        Modules/IntegrationLog/Resources/IntegrationLogResource.php
 * @description Transformasi Model LogIntegrasi ke format JSON API response.
 *              resolved_by dulu dibaca dari relasi Eloquent lintas modul
 *              (dihapus, Hukum Isolasi Total Eloquent) — sekarang dibaca
 *              dari atribut virtual resolved_by_nama yang dipasang
 *              IntegrationLogService::attachResolvedByNama().
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://laravel.com/docs/13.x/eloquent-resources
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\IntegrationLog\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class IntegrationLogResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'integrasi' => $this->integrasi,
            'referensi_tipe' => $this->referensi_tipe,
            'referensi_id' => $this->referensi_id,
            'endpoint' => $this->endpoint,
            'metode' => $this->metode,
            'request_payload' => $this->request_payload,
            'response_payload' => $this->response_payload,
            'status_code' => $this->status_code,
            'level' => $this->level,
            'pesan_error' => $this->pesan_error,
            'status_resolusi' => $this->status_resolusi,
            'catatan_resolusi' => $this->catatan_resolusi,
            'resolved_by' => $this->resolved_by_nama,
            'resolved_at' => $this->resolved_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
