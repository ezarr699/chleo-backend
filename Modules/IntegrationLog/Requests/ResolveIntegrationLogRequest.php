<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Request
 * @file        ResolveIntegrationLogRequest.php
 * @path        Modules/IntegrationLog/Requests/ResolveIntegrationLogRequest.php
 * @description Validasi untuk endpoint POST /integration-log/{id}/resolve.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\IntegrationLog\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ResolveIntegrationLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('log_integrasi.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'catatan_resolusi' => ['required', 'string'],
        ];
    }
}
