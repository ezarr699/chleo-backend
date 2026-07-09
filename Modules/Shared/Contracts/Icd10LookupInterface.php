<?php
/**
 * ============================================================
 * @module      Shared
 * @layer       Contract (Interface)
 * @file        Icd10LookupInterface.php
 * @path        Modules/Shared/Contracts/Icd10LookupInterface.php
 * @description Kontrak baca-saja untuk resolusi kode ICD-10 ke teks
 *              (kode+deskripsi), dipakai RawatJalan untuk SNAPSHOT
 *              (Hukum Snapshot Data) ke pemeriksaan_diagnosis pada saat
 *              diagnosis dicatat — rekam medis eksplisit disebut Hukum
 *              Snapshot sebagai data yang wajib disalin apa adanya, bukan
 *              diandalkan dari relasi dinamis yang bisa berubah kalau
 *              katalog ICD-10 dikoreksi di kemudian hari. Diikat lewat
 *              Icd10\Providers\Icd10ServiceProvider.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Shared\Contracts;

interface Icd10LookupInterface
{
    /** @return array{kode: string, deskripsi: string}|null */
    public function detail(int $icd10Id): ?array;
}
