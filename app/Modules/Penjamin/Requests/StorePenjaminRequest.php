<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Request
 * @file        StorePenjaminRequest.php
 * @path        app/Modules/Penjamin/Requests/StorePenjaminRequest.php
 * @description Validasi & otorisasi untuk endpoint POST /penjamin.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Penjamin\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class StorePenjaminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('penjamin.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::store('penjamin');
    }
}
