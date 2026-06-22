<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Request
 * @file        UpdateAsuransiRequest.php
 * @path        Modules/Asuransi/Requests/UpdateAsuransiRequest.php
 * @description Validasi & otorisasi untuk endpoint PUT /asuransi/{id}.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Asuransi\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateAsuransiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('asuransi.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::update('asuransi', (int) $this->route('id'));
    }
}
