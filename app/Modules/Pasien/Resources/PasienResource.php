<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Resource
 * @file        PasienResource.php
 * @path        app/Modules/Pasien/Resources/PasienResource.php
 * @description Transformasi Model Pasien ke format JSON API response.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://laravel.com/docs/13.x/eloquent-resources
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Pasien\Resources;

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
            'jenis_kelamin' => $this->jenisKelamin ? [
                'id' => $this->jenisKelamin->id,
                'name' => $this->jenisKelamin->name,
            ] : null,
            'status' => $this->status,
            'foto_url' => $this->foto_path ? Storage::disk('public')->url($this->foto_path) : null,
            'tempat_lahir' => $this->tempat_lahir,
            'golongan_darah' => $this->golonganDarah ? [
                'id' => $this->golonganDarah->id,
                'name' => $this->golonganDarah->name,
            ] : null,
            'nomor_telepon' => $this->nomor_telepon,
            'alamat' => $this->alamat,
            'provinsi' => $this->provinsi ? [
                'code' => $this->provinsi->code,
                'name' => $this->provinsi->name,
            ] : null,
            'kabupaten' => $this->kabupaten ? [
                'code' => $this->kabupaten->code,
                'name' => $this->kabupaten->name,
            ] : null,
            'kecamatan' => $this->kecamatan ? [
                'code' => $this->kecamatan->code,
                'name' => $this->kecamatan->name,
            ] : null,
            'kelurahan' => $this->kelurahan ? [
                'code' => $this->kelurahan->code,
                'name' => $this->kelurahan->name,
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
                    'id' => $entry->asuransi->id,
                    'name' => $entry->asuransi->name,
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
