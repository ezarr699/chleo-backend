<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Request
 * @file        VerifyPasienRequest.php
 * @path        app/Modules/Pasien/Requests/VerifyPasienRequest.php
 * @description Validasi untuk endpoint POST /pasien/{id}/verifikasi.
 *              Field data lengkap (foto, tempat lahir, golongan darah,
 *              telepon, alamat) wajib. Informasi BPJS opsional dan tetap
 *              1 entri (BPJS hanya satu per orang). Asuransi tambahan
 *              opsional dan berupa ARRAY — satu pasien boleh punya
 *              banyak entri asuransi swasta sekaligus.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Pasien\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class VerifyPasienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('pasien.verifikasi') ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'foto' => ['required', 'image', 'max:2048'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'golongan_darah_id' => ['required', 'integer', 'exists:golongan_darah,id'],
            'nomor_telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'provinsi_code' => ['nullable', 'string', 'exists:App\Models\Provinsi,code'],
            'kabupaten_code' => ['nullable', 'string', 'exists:App\Models\Kabupaten,code'],
            'kecamatan_code' => ['nullable', 'string', 'exists:App\Models\Kecamatan,code'],
            'kelurahan_code' => ['nullable', 'string', 'exists:App\Models\Kelurahan,code'],

            'bpjs_nomor' => ['nullable', 'string', 'max:50'],
            'bpjs_jenis_peserta' => ['nullable', 'string', 'max:255'],
            'bpjs_kelas' => ['nullable', 'string', 'max:255'],
            'bpjs_nama_fasyankes' => ['nullable', 'string', 'max:255'],
            'bpjs_kode_fasyankes' => ['nullable', 'string', 'max:255'],
            'bpjs_masa_berlaku' => ['nullable', 'date'],

            'asuransi' => ['nullable', 'array'],
            'asuransi.*.asuransi_id' => ['required', 'integer', 'exists:asuransi,id'],
            'asuransi.*.nomor_polis' => ['nullable', 'string', 'max:255'],
            'asuransi.*.masa_berlaku' => ['nullable', 'date'],
        ];
    }
}
