<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Request
 * @file        StorePoliklinikRequest.php
 * @path        Modules/Poliklinik/Requests/StorePoliklinikRequest.php
 * @description Validasi & otorisasi untuk endpoint POST /poliklinik.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Poliklinik\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class StorePoliklinikRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('poliklinik.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::store('poliklinik');
    }
}
