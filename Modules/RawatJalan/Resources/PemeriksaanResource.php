<?php
/**
 * ============================================================
 * @module      RawatJalan
 * @layer       Resource
 * @file        PemeriksaanResource.php
 * @path        Modules/RawatJalan/Resources/PemeriksaanResource.php
 * @description Transformasi Model Pemeriksaan (SOAP + Assessment) ke
 *              format JSON API response. profil_nakes.nama & icd10.kode/
 *              deskripsi dulu dibaca dari relasi Eloquent lintas modul
 *              (dihapus, Hukum Isolasi Total Eloquent) — sekarang dibaca
 *              dari kolom snapshot (nama_nakes_snapshot,
 *              icd10_kode_snapshot, icd10_deskripsi_snapshot) yang
 *              diisi RawatJalanRepository saat pemeriksaan/diagnosis
 *              dicatat (Hukum Snapshot Data).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://laravel.com/docs/13.x/eloquent-resources
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\RawatJalan\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class PemeriksaanResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kunjungan_id' => $this->kunjungan_id,
            'profil_nakes' => [
                'id' => $this->profil_nakes_id,
                'nama' => $this->nama_nakes_snapshot,
            ],
            'subjektif' => $this->subjektif,
            'objektif' => [
                'tekanan_darah_sistolik' => $this->tekanan_darah_sistolik,
                'tekanan_darah_diastolik' => $this->tekanan_darah_diastolik,
                'nadi' => $this->nadi,
                'suhu' => $this->suhu,
                'pernapasan' => $this->pernapasan,
                'saturasi_oksigen' => $this->saturasi_oksigen,
                'tinggi_badan' => $this->tinggi_badan,
                'berat_badan' => $this->berat_badan,
                'lainnya' => $this->objektif_lainnya,
            ],
            'diagnosis' => $this->whenLoaded('diagnosis', fn () => $this->diagnosis->map(fn ($d) => [
                'id' => $d->id,
                'tipe' => $d->tipe,
                'catatan' => $d->catatan,
                'icd10' => [
                    'id' => $d->icd10_id,
                    'kode' => $d->icd10_kode_snapshot,
                    'deskripsi' => $d->icd10_deskripsi_snapshot,
                ],
            ])),
            'rencana' => $this->rencana,
            'diperiksa_pada' => $this->diperiksa_pada?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
