<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Request
 * @file        UpdatePendidikanTerakhirRequest.php
 * @path        app/Modules/PendidikanTerakhir/Requests/UpdatePendidikanTerakhirRequest.php
 * @description Validasi & otorisasi untuk endpoint PUT /pendidikan-terakhir/{id}.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\PendidikanTerakhir\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class UpdatePendidikanTerakhirRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('pendidikan_terakhir.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::update('pendidikan_terakhir', (int) $this->route('id'));
    }
}
