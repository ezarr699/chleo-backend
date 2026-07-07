<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Request
 * @file        UpdateAgamaRequest.php
 * @path        app/Modules/Agama/Requests/UpdateAgamaRequest.php
 * @description Validasi & otorisasi untuk endpoint PUT /agama/{id}.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Agama\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateAgamaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('agama.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::update('agama', (int) $this->route('id'));
    }
}
