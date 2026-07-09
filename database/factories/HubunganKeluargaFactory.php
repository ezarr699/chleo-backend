<?php
/**
 * ============================================================
 * @module      HubunganKeluarga
 * @layer       Database > Factory
 * @file        HubunganKeluargaFactory.php
 * @path        database/factories/HubunganKeluargaFactory.php
 * @description Factory untuk data testing model HubunganKeluarga.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Modules\HubunganKeluarga\Models\HubunganKeluarga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HubunganKeluarga>
 */
class HubunganKeluargaFactory extends Factory
{
    protected $model = HubunganKeluarga::class;

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
