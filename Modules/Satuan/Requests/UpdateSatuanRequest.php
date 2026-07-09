<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Request
 * @file        UpdateSatuanRequest.php
 * @path        Modules/Satuan/Requests/UpdateSatuanRequest.php
 * @description Validasi & otorisasi untuk endpoint PUT /satuan/{id}.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Satuan\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateSatuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('satuan.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::update('satuan', (int) $this->route('id'));
    }
}
