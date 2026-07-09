<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Database > Factory
 * @file        PendidikanTerakhirFactory.php
 * @path        database/factories/PendidikanTerakhirFactory.php
 * @description Factory untuk data testing model PendidikanTerakhir.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Modules\PendidikanTerakhir\Models\PendidikanTerakhir;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PendidikanTerakhir>
 */
class PendidikanTerakhirFactory extends Factory
{
    protected $model = PendidikanTerakhir::class;

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
