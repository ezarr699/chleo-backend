<?php
/**
 * ============================================================
 * @module      GolonganDarah
 * @layer       Request
 * @file        StoreGolonganDarahRequest.php
 * @path        app/Modules/GolonganDarah/Requests/StoreGolonganDarahRequest.php
 * @description Validasi & otorisasi untuk endpoint POST /golongan-darah.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\GolonganDarah\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class StoreGolonganDarahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('golongan_darah.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::store('golongan_darah');
    }
}
