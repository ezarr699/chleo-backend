<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Database > Factory
 * @file        PekerjaanFactory.php
 * @path        database/factories/PekerjaanFactory.php
 * @description Factory untuk data testing model Pekerjaan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Modules\Pekerjaan\Models\Pekerjaan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pekerjaan>
 */
class PekerjaanFactory extends Factory
{
    protected $model = Pekerjaan::class;

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
