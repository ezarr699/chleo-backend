<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Database > Factory
 * @file        PasienAsuransiFactory.php
 * @path        database/factories/PasienAsuransiFactory.php
 * @description Factory untuk data testing model PasienAsuransi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Asuransi\Models\Asuransi;
use Modules\Pasien\Models\Pasien;
use Modules\Pasien\Models\PasienAsuransi;

/**
 * @extends Factory<PasienAsuransi>
 */
class PasienAsuransiFactory extends Factory
{
    protected $model = PasienAsuransi::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pasien_id' => Pasien::factory(),
            'asuransi_id' => Asuransi::factory(),
            'nomor_polis' => fake()->bothify('POL-####'),
        ];
    }
}
