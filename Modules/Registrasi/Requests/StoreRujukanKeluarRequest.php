<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Request
 * @file        StoreRujukanKeluarRequest.php
 * @path        Modules/Registrasi/Requests/StoreRujukanKeluarRequest.php
 * @description Validasi untuk endpoint POST /kunjungan/{id}/rujukan-keluar
 *              (REG-01-2) — merujuk pasien dari kunjungan yang sedang
 *              berjalan ke faskes lain. tujuan_faskes_kode/nama wajib
 *              diisi (ke mana pasien dirujuk).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreRujukanKeluarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('kunjungan.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'tujuan_faskes_kode' => ['required', 'string', 'max:20'],
            'tujuan_faskes_nama' => ['required', 'string', 'max:150'],
            'nomor_rujukan_sisrute' => ['nullable', 'string', 'max:50'],
            'nomor_rujukan_bpjs' => ['nullable', 'string', 'max:50'],
            'diagnosa_rujukan' => ['nullable', 'string', 'max:150'],
            'catatan_rujukan' => ['nullable', 'string'],
            'tanggal_rujukan' => ['nullable', 'date'],
        ];
    }
}
