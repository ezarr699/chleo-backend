<?php
/**
 * ============================================================
 * @module      JenisKelamin
 * @layer       Request
 * @file        StoreJenisKelaminRequest.php
 * @path        app/Modules/JenisKelamin/Requests/StoreJenisKelaminRequest.php
 * @description Validasi & otorisasi untuk endpoint POST /jenis-kelamin.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\JenisKelamin\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class StoreJenisKelaminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('jenis_kelamin.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::store('jenis_kelamin');
    }
}
