<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Resource
 * @file        RegistrasiResource.php
 * @path        Modules/Registrasi/Resources/RegistrasiResource.php
 * @description Transformasi Model Kunjungan ke format JSON API response.
 *              no_antrian_bpjs/no_kunjungan_bpjs/no_sep akan tetap null
 *              sampai modul bridging BPJS (JKN-01-2/INT-01) mengisinya.
 *              rujukan (REG-01-2) berisi riwayat rujukan masuk/keluar
 *              milik kunjungan ini, kosong kalau cara_masuk='walk_in'
 *              dan belum pernah dirujuk keluar. pasien/poliklinik/
 *              profil_nakes/penjamin/registered_by dulu dibaca dari
 *              relasi Eloquent lintas modul (dihapus, Hukum Isolasi Total
 *              Eloquent) — sekarang dibaca dari atribut virtual yang
 *              dipasang RegistrasiService::attachDisplayNames(). Field
 *              kode_bpjs/is_bpjs poliklinik & penjamin SENGAJA tidak lagi
 *              ditampilkan di sini — belum dipakai modul bridging BPJS
 *              manapun saat ini, dan tidak termasuk di payload event
 *              generik (MasterDataCreatedOrUpdated hanya bawa id+nama).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://laravel.com/docs/13.x/eloquent-resources
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class RegistrasiResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'pasien' => [
                'id' => $this->pasien_id,
                'nik' => $this->pasien_nik,
                'nama' => $this->pasien_nama,
            ],
            'poliklinik' => [
                'id' => $this->poliklinik_id,
                'name' => $this->poliklinik_nama,
            ],
            'profil_nakes' => $this->profil_nakes_id ? [
                'id' => $this->profil_nakes_id,
                'nama' => $this->profil_nakes_nama,
            ] : null,
            'penjamin' => [
                'id' => $this->penjamin_id,
                'name' => $this->penjamin_nama,
            ],
            'cara_masuk' => $this->cara_masuk,
            'sumber_booking' => $this->sumber_booking,
            'tanggal_kunjungan' => $this->tanggal_kunjungan?->toDateString(),
            'jam_praktek' => $this->jam_praktek,
            'no_registrasi' => $this->no_registrasi,
            'urutan_harian' => $this->urutan_harian,
            'no_antrian' => $this->no_antrian,
            'angka_antrian' => $this->angka_antrian,
            'no_antrian_bpjs' => $this->no_antrian_bpjs,
            'no_kunjungan_bpjs' => $this->no_kunjungan_bpjs,
            'no_sep' => $this->no_sep,
            'status' => $this->status,
            'alasan_batal' => $this->alasan_batal,
            'catatan' => $this->catatan,
            'registered_by' => $this->registered_by_nama,
            'rujukan' => $this->whenLoaded('rujukan', fn () => $this->rujukan->map(fn ($r) => [
                'id' => $r->id,
                'arah' => $r->arah,
                'asal_faskes_kode' => $r->asal_faskes_kode,
                'asal_faskes_nama' => $r->asal_faskes_nama,
                'tujuan_faskes_kode' => $r->tujuan_faskes_kode,
                'tujuan_faskes_nama' => $r->tujuan_faskes_nama,
                'nomor_rujukan_sisrute' => $r->nomor_rujukan_sisrute,
                'nomor_rujukan_bpjs' => $r->nomor_rujukan_bpjs,
                'diagnosa_rujukan' => $r->diagnosa_rujukan,
                'catatan_rujukan' => $r->catatan_rujukan,
                'tanggal_rujukan' => $r->tanggal_rujukan?->toDateString(),
            ])),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
