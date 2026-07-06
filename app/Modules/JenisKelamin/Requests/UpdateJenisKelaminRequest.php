<?php
/**
 * ============================================================
 * @module      JenisKelamin
 * @layer       Request
 * @file        UpdateJenisKelaminRequest.php
 * @path        app/Modules/JenisKelamin/Requests/UpdateJenisKelaminRequest.php
 * @description Validasi & otorisasi untuk endpoint PUT /jenis-kelamin/{id}.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\JenisKelamin\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateJenisKelaminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('jenis_kelamin.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::update('jenis_kelamin', (int) $this->route('id'));
    }
}
