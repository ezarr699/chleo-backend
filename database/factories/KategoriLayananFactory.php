<?php
/**
 * ============================================================
 * @module      KategoriLayanan
 * @layer       Database > Factory
 * @file        KategoriLayananFactory.php
 * @path        database/factories/KategoriLayananFactory.php
 * @description Factory untuk data testing model KategoriLayanan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use App\Models\KategoriLayanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KategoriLayanan>
 */
class KategoriLayananFactory extends Factory
{
    protected $model = KategoriLayanan::class;

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
