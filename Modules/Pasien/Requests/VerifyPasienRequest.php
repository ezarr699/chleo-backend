<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Request
 * @file        VerifyPasienRequest.php
 * @path        Modules/Pasien/Requests/VerifyPasienRequest.php
 * @description Validasi untuk endpoint POST /pasien/{id}/verifikasi.
 *              Field data lengkap (foto, tempat lahir, golongan darah,
 *              telepon, alamat) wajib. Informasi BPJS opsional dan tetap
 *              1 entri (BPJS hanya satu per orang). Asuransi tambahan
 *              opsional dan berupa ARRAY — satu pasien boleh punya
 *              banyak entri asuransi swasta sekaligus.
 *              Validasi kode wilayah dulu pakai `exists:App\Models\Provinsi,code`
 *              dkk (referensi class Model langsung) — diganti
 *              WilayahLookupInterface::kodeValid() lewat withValidator()
 *              supaya modul Pasien tidak perlu mengenal Model Eloquent
 *              milik Modul Wilayah sama sekali (Hukum Isolasi Total
 *              Eloquent), sekaligus otomatis benar terhadap koneksi
 *              central tempat data wilayah itu sebenarnya berada.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pasien\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Shared\Contracts\WilayahLookupInterface;

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
            'provinsi_code' => ['nullable', 'string'],
            'kabupaten_code' => ['nullable', 'string'],
            'kecamatan_code' => ['nullable', 'string'],
            'kelurahan_code' => ['nullable', 'string'],

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

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $kodeValid = app(WilayahLookupInterface::class)->kodeValid(
                $this->input('provinsi_code'),
                $this->input('kabupaten_code'),
                $this->input('kecamatan_code'),
                $this->input('kelurahan_code'),
            );

            if (! $kodeValid) {
                $validator->errors()->add('provinsi_code', 'Salah satu kode wilayah (provinsi/kabupaten/kecamatan/kelurahan) tidak valid.');
            }
        });
    }
}
