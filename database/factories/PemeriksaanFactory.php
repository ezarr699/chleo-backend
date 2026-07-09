<?php
/**
 * ============================================================
 * @module      RawatJalan
 * @layer       Database > Factory
 * @file        PemeriksaanFactory.php
 * @path        database/factories/PemeriksaanFactory.php
 * @description Factory untuk data testing model Pemeriksaan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ProfilNakes\Models\ProfilNakes;
use Modules\RawatJalan\Models\Pemeriksaan;
use Modules\Registrasi\Models\Kunjungan;

/**
 * @extends Factory<Pemeriksaan>
 */
class PemeriksaanFactory extends Factory
{
    protected $model = Pemeriksaan::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kunjungan_id' => Kunjungan::factory(),
            'profil_nakes_id' => ProfilNakes::factory(),
            'subjektif' => fake()->sentence(),
            'tekanan_darah_sistolik' => fake()->numberBetween(90, 140),
            'tekanan_darah_diastolik' => fake()->numberBetween(60, 90),
            'nadi' => fake()->numberBetween(60, 100),
            'suhu' => fake()->randomFloat(1, 36, 38),
            'pernapasan' => fake()->numberBetween(16, 24),
            'saturasi_oksigen' => fake()->numberBetween(95, 100),
            'tinggi_badan' => fake()->randomFloat(1, 150, 180),
            'berat_badan' => fake()->randomFloat(1, 45, 90),
            'objektif_lainnya' => null,
            'rencana' => fake()->sentence(),
            'diperiksa_pada' => now(),
        ];
    }
}
