<?php
/**
 * ============================================================
 * @module      KategoriObat
 * @layer       Database > Factory
 * @file        KategoriObatFactory.php
 * @path        database/factories/KategoriObatFactory.php
 * @description Factory untuk data testing model KategoriObat.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use App\Models\KategoriObat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KategoriObat>
 */
class KategoriObatFactory extends Factory
{
    protected $model = KategoriObat::class;

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
