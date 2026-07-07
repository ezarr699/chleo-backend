<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Resource
 * @file        ProfilNakesResource.php
 * @path        app/Modules/ProfilNakes/Resources/ProfilNakesResource.php
 * @description Transformasi Model ProfilNakes ke format JSON API response.
 *              Tidak extend MasterDataResource karena bentuknya bukan
 *              {id, name} — ada relasi nested (user, profesi, poliklinik).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\ProfilNakes\Resources;

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
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'profesi' => [
                'id' => $this->profesi->id,
                'name' => $this->profesi->name,
            ],
            'poliklinik' => $this->poliklinik ? [
                'id' => $this->poliklinik->id,
                'name' => $this->poliklinik->name,
            ] : null,
            'no_sip' => $this->no_sip,
            'no_str' => $this->no_str,
            'str_berlaku_sampai' => $this->str_berlaku_sampai?->toDateString(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
