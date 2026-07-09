<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Request
 * @file        StoreSatuanRequest.php
 * @path        Modules/Satuan/Requests/StoreSatuanRequest.php
 * @description Validasi & otorisasi untuk endpoint POST /satuan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Satuan\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class StoreSatuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('satuan.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::store('satuan');
    }
}
