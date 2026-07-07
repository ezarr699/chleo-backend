<?php
/**
 * ============================================================
 * @module      StatusPerkawinan
 * @layer       Request
 * @file        StoreStatusPerkawinanRequest.php
 * @path        app/Modules/StatusPerkawinan/Requests/StoreStatusPerkawinanRequest.php
 * @description Validasi & otorisasi untuk endpoint POST /status-perkawinan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\StatusPerkawinan\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class StoreStatusPerkawinanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('status_perkawinan.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::store('status_perkawinan');
    }
}
