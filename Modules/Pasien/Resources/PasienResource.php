<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Resource
 * @file        PasienResource.php
 * @path        Modules/Pasien/Resources/PasienResource.php
 * @description Transformasi Model Pasien ke format JSON API response.
 *              jenis_kelamin/golongan_darah/provinsi/kabupaten/kecamatan/
 *              kelurahan/asuransi dulu dibaca dari relasi Eloquent lintas
 *              modul (dihapus, Hukum Isolasi Total Eloquent) — sekarang
 *              dibaca dari atribut virtual (*_nama) yang dipasang
 *              PasienService::attachDisplayNames() sebelum Resource ini
 *              dipanggil. code/id-nya sendiri (jenis_kelamin_id dkk)
 *              tetap dari kolom asli di tabel pasien.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://laravel.com/docs/13.x/eloquent-resources
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pasien\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

final class PasienResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nik' => $this->nik,
            'nama' => $this->nama,
            'tanggal_lahir' => $this->tanggal_lahir?->toDateString(),
            'jenis_kelamin' => $this->jenis_kelamin_id ? [
                'id' => $this->jenis_kelamin_id,
                'name' => $this->jenis_kelamin_nama,
            ] : null,
            'status' => $this->status,
            'foto_url' => $this->foto_path ? Storage::disk('public')->url($this->foto_path) : null,
            'tempat_lahir' => $this->tempat_lahir,
            'golongan_darah' => $this->golongan_darah_id ? [
                'id' => $this->golongan_darah_id,
                'name' => $this->golongan_darah_nama,
            ] : null,
            'nomor_telepon' => $this->nomor_telepon,
            'alamat' => $this->alamat,
            'provinsi' => $this->provinsi_code ? [
                'code' => $this->provinsi_code,
                'name' => $this->provinsi_nama,
            ] : null,
            'kabupaten' => $this->kabupaten_code ? [
                'code' => $this->kabupaten_code,
                'name' => $this->kabupaten_nama,
            ] : null,
            'kecamatan' => $this->kecamatan_code ? [
                'code' => $this->kecamatan_code,
                'name' => $this->kecamatan_nama,
            ] : null,
            'kelurahan' => $this->kelurahan_code ? [
                'code' => $this->kelurahan_code,
                'name' => $this->kelurahan_nama,
            ] : null,
            'bpjs_nomor' => $this->bpjs_nomor,
            'bpjs_jenis_peserta' => $this->bpjs_jenis_peserta,
            'bpjs_kelas' => $this->bpjs_kelas,
            'bpjs_nama_fasyankes' => $this->bpjs_nama_fasyankes,
            'bpjs_kode_fasyankes' => $this->bpjs_kode_fasyankes,
            'bpjs_masa_berlaku' => $this->bpjs_masa_berlaku?->toDateString(),
            'asuransi_list' => $this->asuransiList->map(fn ($entry) => [
                'id' => $entry->id,
                'asuransi' => [
                    'id' => $entry->asuransi_id,
                    'name' => $entry->asuransi_nama,
                ],
                'nomor_polis' => $entry->nomor_polis,
                'masa_berlaku' => $entry->masa_berlaku?->toDateString(),
            ])->all(),
            'verified_at' => $this->verified_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
