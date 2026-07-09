<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Database > Factory
 * @file        PenjaminFactory.php
 * @path        database/factories/PenjaminFactory.php
 * @description Factory untuk data testing model Penjamin.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Modules\Penjamin\Models\Penjamin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Penjamin>
 */
class PenjaminFactory extends Factory
{
    protected $model = Penjamin::class;

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
