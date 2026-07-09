<?php
/**
 * ============================================================
 * @module      StatusPerkawinan
 * @layer       Database > Factory
 * @file        StatusPerkawinanFactory.php
 * @path        database/factories/StatusPerkawinanFactory.php
 * @description Factory untuk data testing model StatusPerkawinan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Modules\StatusPerkawinan\Models\StatusPerkawinan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StatusPerkawinan>
 */
class StatusPerkawinanFactory extends Factory
{
    protected $model = StatusPerkawinan::class;

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
