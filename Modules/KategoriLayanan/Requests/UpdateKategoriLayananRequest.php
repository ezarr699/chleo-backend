<?php
/**
 * ============================================================
 * @module      KategoriLayanan
 * @layer       Request
 * @file        UpdateKategoriLayananRequest.php
 * @path        Modules/KategoriLayanan/Requests/UpdateKategoriLayananRequest.php
 * @description Validasi & otorisasi untuk endpoint PUT /kategori-layanan/{id}.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\KategoriLayanan\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateKategoriLayananRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('kategori_layanan.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::update('kategori_layanan', (int) $this->route('id'));
    }
}
