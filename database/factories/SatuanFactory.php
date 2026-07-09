<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Database > Factory
 * @file        SatuanFactory.php
 * @path        database/factories/SatuanFactory.php
 * @description Factory untuk data testing model Satuan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Modules\Satuan\Models\Satuan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Satuan>
 */
class SatuanFactory extends Factory
{
    protected $model = Satuan::class;

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
