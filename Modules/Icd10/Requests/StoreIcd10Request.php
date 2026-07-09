<?php
/**
 * ============================================================
 * @module      Icd10
 * @layer       Request
 * @file        StoreIcd10Request.php
 * @path        Modules/Icd10/Requests/StoreIcd10Request.php
 * @description Validasi untuk endpoint POST /icd10 — menambah kode
 *              ICD-10 yang belum ada di seed awal.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Icd10\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreIcd10Request extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('icd10.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'kode' => ['required', 'string', 'max:10', 'unique:icd10,kode'],
            'deskripsi' => ['required', 'string', 'max:255'],
            'kategori' => ['nullable', 'string', 'max:150'],
        ];
    }
}
