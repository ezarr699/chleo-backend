<?php
/**
 * ============================================================
 * @module      Profesi
 * @layer       Request
 * @file        StoreProfesiRequest.php
 * @path        Modules/Profesi/Requests/StoreProfesiRequest.php
 * @description Validasi & otorisasi untuk endpoint POST /profesi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Profesi\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class StoreProfesiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('profesi.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::store('profesi');
    }
}
