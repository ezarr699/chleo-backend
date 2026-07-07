<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Request
 * @file        StorePendidikanTerakhirRequest.php
 * @path        app/Modules/PendidikanTerakhir/Requests/StorePendidikanTerakhirRequest.php
 * @description Validasi & otorisasi untuk endpoint POST /pendidikan-terakhir.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\PendidikanTerakhir\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class StorePendidikanTerakhirRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('pendidikan_terakhir.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::store('pendidikan_terakhir');
    }
}
