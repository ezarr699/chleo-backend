<?php
/**
 * ============================================================
 * @module      Icd10
 * @layer       Database > Factory
 * @file        Icd10Factory.php
 * @path        database/factories/Icd10Factory.php
 * @description Factory untuk data testing model Icd10.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Icd10\Models\Icd10;

/**
 * @extends Factory<Icd10>
 */
class Icd10Factory extends Factory
{
    protected $model = Icd10::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => strtoupper(fake()->unique()->bothify('?##.#')),
            'deskripsi' => fake()->sentence(3),
            'kategori' => fake()->words(2, true),
        ];
    }
}
