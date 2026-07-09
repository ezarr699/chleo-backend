<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Database > Factory
 * @file        KunjunganFactory.php
 * @path        database/factories/KunjunganFactory.php
 * @description Factory untuk data testing model Kunjungan. Nilai
 *              penomoran (urutan_harian/no_registrasi/angka_antrian/
 *              no_antrian) di-generate acak-unik di sini murni supaya
 *              memenuhi constraint kolom NOT NULL/unique — alur
 *              penomoran yang sesungguhnya (aman dari race condition)
 *              hanya dijamin lewat RegistrasiRepository::createWalkIn(),
 *              bukan lewat factory ini.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Pasien\Models\Pasien;
use Modules\Penjamin\Models\Penjamin;
use Modules\Poliklinik\Models\Poliklinik;
use Modules\Registrasi\Models\Kunjungan;

/**
 * @extends Factory<Kunjungan>
 */
class KunjunganFactory extends Factory
{
    protected $model = Kunjungan::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $urutan = fake()->unique()->numberBetween(1, 1000000);

        return [
            'pasien_id' => Pasien::factory(),
            'poliklinik_id' => Poliklinik::factory(),
            'profil_nakes_id' => null,
            'penjamin_id' => Penjamin::factory(),
            'cara_masuk' => 'walk_in',
            'tanggal_kunjungan' => now()->toDateString(),
            'urutan_harian' => $urutan,
            'no_registrasi' => sprintf('REG-%s-%04d', now()->format('Ymd'), $urutan),
            'angka_antrian' => $urutan,
            'no_antrian' => sprintf('A-%03d', $urutan),
            'status' => 'menunggu',
        ];
    }
}
