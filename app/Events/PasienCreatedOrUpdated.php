<?php
/**
 * ============================================================
 * @module      Core
 * @layer       Event (Global)
 * @file        PasienCreatedOrUpdated.php
 * @path        app/Events/PasienCreatedOrUpdated.php
 * @description Global Event yang menjembatani Modul Pasien (Publisher)
 *              dengan modul-modul lain yang butuh replika data pasien
 *              (mis. Modul Billing) TANPA saling import Model Eloquent
 *              (Hukum Isolasi Total Eloquent). Hanya membawa data
 *              primitif (int/string) hasil snapshot pada saat pasien
 *              dibuat/diperbarui — dilarang keras membawa instance
 *              Model \App\Models\Pasien secara utuh, karena itu akan
 *              memaksa Subscriber mengenal skema/relasi Eloquent milik
 *              Modul Pasien dan meniadakan isolasi antar modul.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://laravel.com/docs/13.x/events
 * ============================================================
 */

declare(strict_types=1);

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

final class PasienCreatedOrUpdated
{
    use Dispatchable;

    public function __construct(
        public readonly int $pasienId,
        public readonly string $nama,
        public readonly ?string $noRm = null,
        public readonly ?string $nik = null,
    ) {}

    /** @return array{pasien_id: int, nama: string, no_rm: ?string, nik: ?string} */
    public function toArray(): array
    {
        return [
            'pasien_id' => $this->pasienId,
            'nama' => $this->nama,
            'no_rm' => $this->noRm,
            'nik' => $this->nik,
        ];
    }
}
