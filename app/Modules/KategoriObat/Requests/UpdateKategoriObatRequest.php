<?php
/**
 * ============================================================
 * @module      KategoriObat
 * @layer       Request
 * @file        UpdateKategoriObatRequest.php
 * @path        app/Modules/KategoriObat/Requests/UpdateKategoriObatRequest.php
 * @description Validasi & otorisasi untuk endpoint PUT /kategori-obat/{id}.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\KategoriObat\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateKategoriObatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('kategori_obat.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::update('kategori_obat', (int) $this->route('id'));
    }
}
