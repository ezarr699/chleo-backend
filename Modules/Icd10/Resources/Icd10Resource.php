<?php
/**
 * ============================================================
 * @module      Icd10
 * @layer       Resource
 * @file        Icd10Resource.php
 * @path        Modules/Icd10/Resources/Icd10Resource.php
 * @description Transformasi Model Icd10 ke format JSON API response.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://laravel.com/docs/13.x/eloquent-resources
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Icd10\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class Icd10Resource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode' => $this->kode,
            'deskripsi' => $this->deskripsi,
            'kategori' => $this->kategori,
        ];
    }
}
