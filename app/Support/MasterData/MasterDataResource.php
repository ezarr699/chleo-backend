<?php
/**
 * ============================================================
 * @module      MasterData
 * @layer       Resource
 * @file        MasterDataResource.php
 * @path        app/Support/MasterData/MasterDataResource.php
 * @description Transformasi response generik untuk data master.
 *              Setiap modul punya Resource sendiri yang extends class
 *              ini (body kosong) — lihat Modules/Agama/Resources/AgamaResource.php.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://laravel.com/docs/13.x/eloquent-resources
 * ============================================================
 */

declare(strict_types=1);

namespace App\Support\MasterData;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class MasterDataResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
