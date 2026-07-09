<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Request
 * @file        StoreRujukanMasukRequest.php
 * @path        Modules/Registrasi/Requests/StoreRujukanMasukRequest.php
 * @description Validasi untuk endpoint POST /kunjungan/rujukan-masuk
 *              (REG-01-2) — registrasi pasien yang datang membawa
 *              rujukan dari faskes lain. asal_faskes_kode/nama wajib
 *              diisi (siapa yang merujuk); nomor_rujukan_sisrute dan
 *              nomor_rujukan_bpjs nullable karena bisa jadi rujukan
 *              manual/kertas yang belum tercatat di sistem manapun.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreRujukanMasukRequest extends FormRequest
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

            'asal_faskes_kode' => ['required', 'string', 'max:20'],
            'asal_faskes_nama' => ['required', 'string', 'max:150'],
            'nomor_rujukan_sisrute' => ['nullable', 'string', 'max:50'],
            'nomor_rujukan_bpjs' => ['nullable', 'string', 'max:50'],
            'diagnosa_rujukan' => ['nullable', 'string', 'max:150'],
            'catatan_rujukan' => ['nullable', 'string'],
            'tanggal_rujukan' => ['nullable', 'date'],
        ];
    }
}
