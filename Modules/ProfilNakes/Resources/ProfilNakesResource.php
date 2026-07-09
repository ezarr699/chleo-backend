<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Resource
 * @file        ProfilNakesResource.php
 * @path        Modules/ProfilNakes/Resources/ProfilNakesResource.php
 * @description Transformasi Model ProfilNakes ke format JSON API response.
 *              user/profesi/poliklinik dulu dibaca dari relasi Eloquent
 *              lintas modul (dihapus, Hukum Isolasi Total Eloquent) —
 *              sekarang dibaca dari atribut virtual (user_nama, user_email,
 *              profesi_nama, poliklinik_nama) yang dipasang
 *              ProfilNakesService::attachDisplayNames().
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\ProfilNakes\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProfilNakesResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user_id,
                'name' => $this->user_nama,
                'email' => $this->user_email,
            ],
            'profesi' => [
                'id' => $this->profesi_id,
                'name' => $this->profesi_nama,
            ],
            'poliklinik' => $this->poliklinik_id ? [
                'id' => $this->poliklinik_id,
                'name' => $this->poliklinik_nama,
            ] : null,
            'no_sip' => $this->no_sip,
            'no_str' => $this->no_str,
            'str_berlaku_sampai' => $this->str_berlaku_sampai?->toDateString(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
