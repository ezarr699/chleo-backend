<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Request
 * @file        StoreAgamaRequest.php
 * @path        app/Modules/Agama/Requests/StoreAgamaRequest.php
 * @description Validasi & otorisasi untuk endpoint POST /agama.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Agama\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class StoreAgamaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('agama.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::store('agama');
    }
}
