<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Request
 * @file        StoreAsuransiRequest.php
 * @path        Modules/Asuransi/Requests/StoreAsuransiRequest.php
 * @description Validasi & otorisasi untuk endpoint POST /asuransi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Asuransi\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class StoreAsuransiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('asuransi.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::store('asuransi');
    }
}
