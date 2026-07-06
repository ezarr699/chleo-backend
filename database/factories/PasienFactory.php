<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Database > Factory
 * @file        PasienFactory.php
 * @path        database/factories/PasienFactory.php
 * @description Factory untuk data testing model Pasien.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use App\Models\JenisKelamin;
use App\Models\Pasien;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pasien>
 */
class PasienFactory extends Factory
{
    protected $model = Pasien::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => fake()->unique()->numerify('################'),
            'nama' => fake()->name(),
            'tanggal_lahir' => fake()->date(),
            'jenis_kelamin_id' => JenisKelamin::factory(),
            'status' => 'belum_verifikasi',
        ];
    }
}
