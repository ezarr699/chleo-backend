<?php
/**
 * ============================================================
 * @module      KategoriTriase
 * @layer       Database > Factory
 * @file        KategoriTriaseFactory.php
 * @path        database/factories/KategoriTriaseFactory.php
 * @description Factory untuk data testing model KategoriTriase.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Modules\KategoriTriase\Models\KategoriTriase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KategoriTriase>
 */
class KategoriTriaseFactory extends Factory
{
    protected $model = KategoriTriase::class;

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
