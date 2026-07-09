<?php
/**
 * ============================================================
 * @module      GolonganDarah
 * @layer       Database > Factory
 * @file        GolonganDarahFactory.php
 * @path        database/factories/GolonganDarahFactory.php
 * @description Factory untuk data testing model GolonganDarah.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Modules\GolonganDarah\Models\GolonganDarah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GolonganDarah>
 */
class GolonganDarahFactory extends Factory
{
    protected $model = GolonganDarah::class;

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
