<?php
/**
 * ============================================================
 * @module      JenisKelamin
 * @layer       Database > Factory
 * @file        JenisKelaminFactory.php
 * @path        database/factories/JenisKelaminFactory.php
 * @description Factory untuk data testing model JenisKelamin.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Modules\JenisKelamin\Models\JenisKelamin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JenisKelamin>
 */
class JenisKelaminFactory extends Factory
{
    protected $model = JenisKelamin::class;

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
