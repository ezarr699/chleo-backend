<?php
/**
 * ============================================================
 * @module      Icd10
 * @layer       Service
 * @file        Icd10LookupService.php
 * @path        Modules/Icd10/Services/Icd10LookupService.php
 * @description Implementasi Shared\Contracts\Icd10LookupInterface —
 *              satu-satunya jalur modul lain (mis. RawatJalan) boleh
 *              membaca kode+deskripsi ICD-10 untuk SNAPSHOT ke rekam
 *              medis, tanpa pernah mengimpor Model Icd10 secara langsung.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Icd10\Services;

use Modules\Icd10\Models\Icd10;
use Modules\Shared\Contracts\Icd10LookupInterface;

final class Icd10LookupService implements Icd10LookupInterface
{
    public function detail(int $icd10Id): ?array
    {
        $icd10 = Icd10::query()->find($icd10Id, ['kode', 'deskripsi']);

        if ($icd10 === null) {
            return null;
        }

        return ['kode' => $icd10->kode, 'deskripsi' => $icd10->deskripsi];
    }
}
