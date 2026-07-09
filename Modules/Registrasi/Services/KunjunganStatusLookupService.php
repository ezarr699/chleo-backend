<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Service
 * @file        KunjunganStatusLookupService.php
 * @path        Modules/Registrasi/Services/KunjunganStatusLookupService.php
 * @description Implementasi Shared\Contracts\KunjunganStatusInterface —
 *              satu-satunya jalur modul lain (mis. RawatJalan, Jkn) boleh
 *              membaca status Kunjungan TERKINI atau menulis no_sep,
 *              tanpa mengimpor Model Kunjungan. Query/update LANGSUNG ke
 *              tabel kunjungan, TIDAK lewat cache — lihat catatan
 *              lengkap di kontraknya soal kenapa.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Services;

use Modules\Registrasi\Models\Kunjungan;
use Modules\Shared\Contracts\KunjunganStatusInterface;

final class KunjunganStatusLookupService implements KunjunganStatusInterface
{
    public function detail(int $kunjunganId): ?array
    {
        $kunjungan = Kunjungan::query()->find($kunjunganId, ['id', 'status', 'no_registrasi']);

        if ($kunjungan === null) {
            return null;
        }

        return ['id' => $kunjungan->id, 'status' => $kunjungan->status, 'no_registrasi' => $kunjungan->no_registrasi];
    }

    public function updateNoSep(int $kunjunganId, string $noSep): void
    {
        Kunjungan::query()->whereKey($kunjunganId)->update(['no_sep' => $noSep]);
    }
}
