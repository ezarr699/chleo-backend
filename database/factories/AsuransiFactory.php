<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Database > Factory
 * @file        AsuransiFactory.php
 * @path        database/factories/AsuransiFactory.php
 * @description Factory untuk data testing model Asuransi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use App\Models\Asuransi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Asuransi>
 */
class AsuransiFactory extends Factory
{
    protected $model = Asuransi::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
        ];
    }
}
