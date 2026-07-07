<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Database > Factory
 * @file        ProfilNakesFactory.php
 * @path        database/factories/ProfilNakesFactory.php
 * @description Factory untuk data testing model ProfilNakes.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use App\Models\Poliklinik;
use App\Models\Profesi;
use App\Models\ProfilNakes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProfilNakes>
 */
class ProfilNakesFactory extends Factory
{
    protected $model = ProfilNakes::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'profesi_id' => Profesi::factory(),
            'poliklinik_id' => Poliklinik::factory(),
            'no_sip' => fake()->numerify('SIP-##########'),
            'no_str' => fake()->numerify('STR-##########'),
            'str_berlaku_sampai' => fake()->dateTimeBetween('now', '+5 years')->format('Y-m-d'),
        ];
    }
}
