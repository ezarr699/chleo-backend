<?php
/**
 * ============================================================
 * @module      HubunganKeluarga
 * @layer       Request
 * @file        StoreHubunganKeluargaRequest.php
 * @path        Modules/HubunganKeluarga/Requests/StoreHubunganKeluargaRequest.php
 * @description Validasi & otorisasi untuk endpoint POST /hubungan-keluarga.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\HubunganKeluarga\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class StoreHubunganKeluargaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('hubungan_keluarga.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::store('hubungan_keluarga');
    }
}
