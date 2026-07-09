<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Database > Factory
 * @file        KunjunganRujukanFactory.php
 * @path        database/factories/KunjunganRujukanFactory.php
 * @description Factory untuk data testing model KunjunganRujukan
 *              (REG-01-2). Default arah 'masuk' dengan data faskes asal
 *              acak; gunakan state keluar() untuk skenario rujukan
 *              keluar.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Registrasi\Models\Kunjungan;
use Modules\Registrasi\Models\KunjunganRujukan;

/**
 * @extends Factory<KunjunganRujukan>
 */
class KunjunganRujukanFactory extends Factory
{
    protected $model = KunjunganRujukan::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kunjungan_id' => Kunjungan::factory(),
            'arah' => 'masuk',
            'asal_faskes_kode' => fake()->numerify('FKTP###'),
            'asal_faskes_nama' => fake()->company(),
            'tujuan_faskes_kode' => null,
            'tujuan_faskes_nama' => null,
            'nomor_rujukan_sisrute' => null,
            'nomor_rujukan_bpjs' => null,
            'diagnosa_rujukan' => fake()->word(),
            'catatan_rujukan' => null,
            'tanggal_rujukan' => now()->toDateString(),
        ];
    }

    public function keluar(): static
    {
        return $this->state(fn () => [
            'arah' => 'keluar',
            'asal_faskes_kode' => null,
            'asal_faskes_nama' => null,
            'tujuan_faskes_kode' => fake()->numerify('FKRTL###'),
            'tujuan_faskes_nama' => fake()->company(),
        ]);
    }
}
