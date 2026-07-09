<?php
/**
 * ============================================================
 * @module      Icd10
 * @layer       Database > Seeder (Tenant)
 * @file        Icd10Seeder.php
 * @path        Modules/Icd10/Database/Seeders/Icd10Seeder.php
 * @description Seed subset kode ICD-10 yang umum dipakai diagnosis
 *              rawat jalan Indonesia (demam, ISPA, hipertensi, diabetes,
 *              gastritis, dst). BUKAN katalog WHO ICD-10 lengkap
 *              (~14.000 kode) — itu perlu proses import terpisah
 *              (mis. CSV resmi WHO/Kemenkes) yang di luar scope RWJ-01-1-1
 *              iterasi ini. idempotent lewat updateOrCreate(kode).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Icd10\Database\Seeders;

use Modules\Icd10\Models\Icd10;
use Illuminate\Database\Seeder;

class Icd10Seeder extends Seeder
{
    /** @var array<int, array{kode: string, deskripsi: string, kategori: string}> */
    private const KODE = [
        ['kode' => 'A09', 'deskripsi' => 'Diare dan gastroenteritis', 'kategori' => 'Penyakit infeksi & parasit'],
        ['kode' => 'A90', 'deskripsi' => 'Demam dengue', 'kategori' => 'Penyakit infeksi & parasit'],
        ['kode' => 'B34.9', 'deskripsi' => 'Infeksi virus, tidak spesifik', 'kategori' => 'Penyakit infeksi & parasit'],
        ['kode' => 'E10.9', 'deskripsi' => 'Diabetes melitus tipe 1 tanpa komplikasi', 'kategori' => 'Penyakit endokrin & metabolik'],
        ['kode' => 'E11.9', 'deskripsi' => 'Diabetes melitus tipe 2 tanpa komplikasi', 'kategori' => 'Penyakit endokrin & metabolik'],
        ['kode' => 'H10.9', 'deskripsi' => 'Konjungtivitis, tidak spesifik', 'kategori' => 'Penyakit mata'],
        ['kode' => 'H66.9', 'deskripsi' => 'Otitis media, tidak spesifik', 'kategori' => 'Penyakit telinga'],
        ['kode' => 'I10', 'deskripsi' => 'Hipertensi esensial (primer)', 'kategori' => 'Penyakit sistem sirkulasi'],
        ['kode' => 'I50.9', 'deskripsi' => 'Gagal jantung, tidak spesifik', 'kategori' => 'Penyakit sistem sirkulasi'],
        ['kode' => 'J00', 'deskripsi' => 'Nasofaringitis akut (common cold)', 'kategori' => 'Penyakit sistem pernapasan'],
        ['kode' => 'J02.9', 'deskripsi' => 'Faringitis akut, tidak spesifik', 'kategori' => 'Penyakit sistem pernapasan'],
        ['kode' => 'J03.9', 'deskripsi' => 'Tonsilitis akut, tidak spesifik', 'kategori' => 'Penyakit sistem pernapasan'],
        ['kode' => 'J06.9', 'deskripsi' => 'Infeksi akut saluran napas atas, tidak spesifik', 'kategori' => 'Penyakit sistem pernapasan'],
        ['kode' => 'J18.9', 'deskripsi' => 'Pneumonia, tidak spesifik', 'kategori' => 'Penyakit sistem pernapasan'],
        ['kode' => 'J45.9', 'deskripsi' => 'Asma, tidak spesifik', 'kategori' => 'Penyakit sistem pernapasan'],
        ['kode' => 'K29.7', 'deskripsi' => 'Gastritis, tidak spesifik', 'kategori' => 'Penyakit sistem pencernaan'],
        ['kode' => 'K30', 'deskripsi' => 'Dispepsia', 'kategori' => 'Penyakit sistem pencernaan'],
        ['kode' => 'L23.9', 'deskripsi' => 'Dermatitis kontak alergi, tidak spesifik', 'kategori' => 'Penyakit kulit'],
        ['kode' => 'L30.9', 'deskripsi' => 'Dermatitis, tidak spesifik', 'kategori' => 'Penyakit kulit'],
        ['kode' => 'M54.5', 'deskripsi' => 'Nyeri punggung bawah (low back pain)', 'kategori' => 'Penyakit muskuloskeletal'],
        ['kode' => 'M79.1', 'deskripsi' => 'Mialgia', 'kategori' => 'Penyakit muskuloskeletal'],
        ['kode' => 'N39.0', 'deskripsi' => 'Infeksi saluran kemih', 'kategori' => 'Penyakit sistem kemih'],
        ['kode' => 'R05', 'deskripsi' => 'Batuk', 'kategori' => 'Gejala & tanda umum'],
        ['kode' => 'R11', 'deskripsi' => 'Mual dan muntah', 'kategori' => 'Gejala & tanda umum'],
        ['kode' => 'R50.9', 'deskripsi' => 'Demam, tidak spesifik', 'kategori' => 'Gejala & tanda umum'],
        ['kode' => 'R51', 'deskripsi' => 'Nyeri kepala', 'kategori' => 'Gejala & tanda umum'],
        ['kode' => 'Z00.0', 'deskripsi' => 'Pemeriksaan medis umum', 'kategori' => 'Faktor yang mempengaruhi status kesehatan'],
    ];

    public function run(): void
    {
        foreach (self::KODE as $item) {
            Icd10::query()->updateOrCreate(['kode' => $item['kode']], $item);
        }
    }
}
