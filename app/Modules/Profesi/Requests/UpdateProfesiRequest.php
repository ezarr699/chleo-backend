<?php
/**
 * ============================================================
 * @module      Profesi
 * @layer       Request
 * @file        UpdateProfesiRequest.php
 * @path        app/Modules/Profesi/Requests/UpdateProfesiRequest.php
 * @description Validasi & otorisasi untuk endpoint PUT /profesi/{id}.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Profesi\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateProfesiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('profesi.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::update('profesi', (int) $this->route('id'));
    }
}
