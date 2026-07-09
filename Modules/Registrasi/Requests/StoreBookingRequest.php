<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Request
 * @file        StoreBookingRequest.php
 * @path        Modules/Registrasi/Requests/StoreBookingRequest.php
 * @description Validasi untuk endpoint POST /kunjungan/booking (REG-01-3)
 *              — online booking lewat Mobile JKN atau Web Portal.
 *              tanggal_kunjungan wajib diisi (hari ini atau masa depan,
 *              beda dari walk-in yang defaultnya hari ini) karena
 *              booking secara definisi dibuat sebelum pasien datang.
 *              sumber_booking wajib salah satu dari web_portal/mobile_jkn
 *              supaya jelas channel asal booking.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('kunjungan.manage') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'pasien_id' => ['required', 'integer', 'exists:pasien,id'],
            'poliklinik_id' => ['required', 'integer', 'exists:poliklinik,id'],
            'profil_nakes_id' => ['nullable', 'integer', 'exists:profil_nakes,id'],
            'penjamin_id' => ['required', 'integer', 'exists:penjamin,id'],
            'tanggal_kunjungan' => ['required', 'date', 'after_or_equal:today'],
            'jam_praktek' => ['nullable', 'string', 'max:20'],
            'sumber_booking' => ['required', 'string', 'in:web_portal,mobile_jkn'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
