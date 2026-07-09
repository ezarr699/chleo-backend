<?php
/**
 * ============================================================
 * @module      RawatJalan
 * @layer       Request
 * @file        StorePemeriksaanRequest.php
 * @path        Modules/RawatJalan/Requests/StorePemeriksaanRequest.php
 * @description Validasi untuk endpoint POST /kunjungan/{id}/pemeriksaan
 *              — form SOAP (Subjective/Objective/Plan) + Assessment
 *              (array diagnosis ICD-10, wajib minimal 1 dengan tepat
 *              satu tipe 'utama' — dicek di RawatJalanService, bukan
 *              di sini, karena butuh hitung across-array).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\RawatJalan\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StorePemeriksaanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('pemeriksaan.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'profil_nakes_id' => ['required', 'integer', 'exists:profil_nakes,id'],
            'subjektif' => ['nullable', 'string'],

            'tekanan_darah_sistolik' => ['nullable', 'integer', 'min:0', 'max:300'],
            'tekanan_darah_diastolik' => ['nullable', 'integer', 'min:0', 'max:200'],
            'nadi' => ['nullable', 'integer', 'min:0', 'max:300'],
            'suhu' => ['nullable', 'numeric', 'min:30', 'max:45'],
            'pernapasan' => ['nullable', 'integer', 'min:0', 'max:100'],
            'saturasi_oksigen' => ['nullable', 'integer', 'min:0', 'max:100'],
            'tinggi_badan' => ['nullable', 'numeric', 'min:0', 'max:300'],
            'berat_badan' => ['nullable', 'numeric', 'min:0', 'max:500'],
            'objektif_lainnya' => ['nullable', 'string'],

            'rencana' => ['nullable', 'string'],
            'diperiksa_pada' => ['nullable', 'date'],

            'diagnosis' => ['required', 'array', 'min:1'],
            'diagnosis.*.icd10_id' => ['required', 'integer', 'exists:icd10,id'],
            'diagnosis.*.tipe' => ['required', 'string', 'in:utama,sekunder'],
            'diagnosis.*.catatan' => ['nullable', 'string', 'max:255'],
        ];
    }
}
