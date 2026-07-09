<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Request
 * @file        StoreRegistrasiRequest.php
 * @path        Modules/Registrasi/Requests/StoreRegistrasiRequest.php
 * @description Validasi untuk endpoint POST /kunjungan — registrasi
 *              walk-in (REG-01-1). tanggal_kunjungan opsional, default
 *              hari ini kalau tidak diisi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreRegistrasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('kunjungan.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'pasien_id' => ['required', 'integer', 'exists:pasien,id'],
            'poliklinik_id' => ['required', 'integer', 'exists:poliklinik,id'],
            'profil_nakes_id' => ['nullable', 'integer', 'exists:profil_nakes,id'],
            'penjamin_id' => ['required', 'integer', 'exists:penjamin,id'],
            'tanggal_kunjungan' => ['nullable', 'date'],
            'jam_praktek' => ['nullable', 'string', 'max:20'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
