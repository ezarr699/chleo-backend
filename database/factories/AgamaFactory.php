<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Database > Factory
 * @file        AgamaFactory.php
 * @path        database/factories/AgamaFactory.php
 * @description Factory untuk data testing model Agama.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Agama\Models\Agama;

/**
 * @extends Factory<Agama>
 */
class AgamaFactory extends Factory
{
    protected $model = Agama::class;

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
