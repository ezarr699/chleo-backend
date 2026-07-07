<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Database > Factory
 * @file        PoliklinikFactory.php
 * @path        database/factories/PoliklinikFactory.php
 * @description Factory untuk data testing model Poliklinik.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use App\Models\Poliklinik;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Poliklinik>
 */
class PoliklinikFactory extends Factory
{
    protected $model = Poliklinik::class;

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
