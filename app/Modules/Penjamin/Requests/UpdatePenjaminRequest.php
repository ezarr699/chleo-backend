<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Request
 * @file        UpdatePenjaminRequest.php
 * @path        app/Modules/Penjamin/Requests/UpdatePenjaminRequest.php
 * @description Validasi & otorisasi untuk endpoint PUT /penjamin/{id}.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Penjamin\Requests;

use App\Support\MasterData\MasterDataValidationRules;
use Illuminate\Foundation\Http\FormRequest;

final class UpdatePenjaminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('penjamin.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return MasterDataValidationRules::update('penjamin', (int) $this->route('id'));
    }
}
