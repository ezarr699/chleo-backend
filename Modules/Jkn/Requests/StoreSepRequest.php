<?php
/**
 * ============================================================
 * @module      Jkn
 * @layer       Request
 * @file        StoreSepRequest.php
 * @path        Modules/Jkn/Requests/StoreSepRequest.php
 * @description Validasi untuk endpoint POST /kunjungan/{id}/sep — buat
 *              SEP BPJS untuk kunjungan yang sudah terdaftar. Field
 *              mengikuti struktur inti SEP/1.1 V-Claim yang stabil;
 *              lihat catatan verifikasi di VClaimService::buildSepPayload().
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Jkn\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreSepRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('bpjs_vclaim.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'no_kartu' => ['required', 'string', 'max:20'],
            'tanggal_sep' => ['required', 'date'],
            'ppk_pelayanan' => ['required', 'string', 'max:10'],
            'jenis_pelayanan' => ['required', 'string', 'in:rawat_inap,rawat_jalan'],
            'kelas_rawat' => ['nullable', 'string', 'in:1,2,3'],
            'poli_tujuan' => ['required', 'string', 'max:10'],
            'diagnosa_awal' => ['nullable', 'string', 'max:10'],
            'no_rujukan' => ['nullable', 'string', 'max:50'],
            'catatan' => ['nullable', 'string'],
            'no_telp' => ['nullable', 'string', 'max:20'],
        ];
    }
}
