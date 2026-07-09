<?php
/**
 * ============================================================
 * @module      KategoriTriase
 * @layer       Request
 * @file        UpdateKategoriTriaseRequest.php
 * @path        Modules/KategoriTriase/Requests/UpdateKategoriTriaseRequest.php
 * @description Validasi & otorisasi untuk endpoint PUT /kategori-triase/{id}.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\KategoriTriase\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateKategoriTriaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('kategori_triase.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::update('kategori_triase', (int) $this->route('id'));
    }
}
