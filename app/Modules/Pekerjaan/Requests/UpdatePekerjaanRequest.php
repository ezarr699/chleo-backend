<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Request
 * @file        UpdatePekerjaanRequest.php
 * @path        app/Modules/Pekerjaan/Requests/UpdatePekerjaanRequest.php
 * @description Validasi & otorisasi untuk endpoint PUT /pekerjaan/{id}.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Pekerjaan\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class UpdatePekerjaanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('pekerjaan.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::update('pekerjaan', (int) $this->route('id'));
    }
}
