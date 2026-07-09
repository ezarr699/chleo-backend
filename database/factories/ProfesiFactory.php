<?php
/**
 * ============================================================
 * @module      Profesi
 * @layer       Database > Factory
 * @file        ProfesiFactory.php
 * @path        database/factories/ProfesiFactory.php
 * @description Factory untuk data testing model Profesi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Modules\Profesi\Models\Profesi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profesi>
 */
class ProfesiFactory extends Factory
{
    protected $model = Profesi::class;

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
