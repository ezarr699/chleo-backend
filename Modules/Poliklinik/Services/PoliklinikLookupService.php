<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Service
 * @file        PoliklinikLookupService.php
 * @path        Modules/Poliklinik/Services/PoliklinikLookupService.php
 * @description Implementasi Shared\Contracts\PoliklinikLookupInterface —
 *              satu-satunya jalur modul lain (mis. Registrasi) boleh
 *              menghitung prefix nomor antrian, tanpa pernah mengimpor
 *              Model Poliklinik secara langsung. Logika sama persis
 *              dengan yang dulu ada di
 *              app/Modules/Registrasi/Repositories/RegistrasiRepository.php::antrianPrefix() —
 *              dipindah ke sini karena "bagaimana menurunkan prefix dari
 *              data poliklinik" adalah pengetahuan milik modul ini.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Poliklinik\Services;

use Illuminate\Support\Str;
use Modules\Poliklinik\Models\Poliklinik;
use Modules\Shared\Contracts\PoliklinikLookupInterface;

final class PoliklinikLookupService implements PoliklinikLookupInterface
{
    public function antrianPrefix(int $poliklinikId): string
    {
        $poliklinik = Poliklinik::query()->find($poliklinikId);

        if ($poliklinik === null) {
            return 'REG';
        }

        if (! empty($poliklinik->kode_bpjs)) {
            return strtoupper($poliklinik->kode_bpjs);
        }

        return strtoupper(Str::of($poliklinik->name)->squish()->replaceMatches('/[^A-Za-z]/', '')->substr(0, 3)->value() ?: 'REG');
    }
}
