<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Request
 * @file        StorePekerjaanRequest.php
 * @path        Modules/Pekerjaan/Requests/StorePekerjaanRequest.php
 * @description Validasi & otorisasi untuk endpoint POST /pekerjaan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pekerjaan\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class StorePekerjaanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('pekerjaan.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::store('pekerjaan');
    }
}
