<?php
/**
 * ============================================================
 * @module      HubunganKeluarga
 * @layer       Request
 * @file        UpdateHubunganKeluargaRequest.php
 * @path        app/Modules/HubunganKeluarga/Requests/UpdateHubunganKeluargaRequest.php
 * @description Validasi & otorisasi untuk endpoint PUT /hubungan-keluarga/{id}.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\HubunganKeluarga\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateHubunganKeluargaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('hubungan_keluarga.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::update('hubungan_keluarga', (int) $this->route('id'));
    }
}
