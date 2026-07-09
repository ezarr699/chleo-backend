<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Database > Factory
 * @file        LogIntegrasiFactory.php
 * @path        database/factories/LogIntegrasiFactory.php
 * @description Factory untuk data testing model LogIntegrasi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\IntegrationLog\Models\LogIntegrasi;

/**
 * @extends Factory<LogIntegrasi>
 */
class LogIntegrasiFactory extends Factory
{
    protected $model = LogIntegrasi::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'integrasi' => fake()->randomElement(['bpjs_vclaim', 'bpjs_antrean', 'sisrute']),
            'referensi_tipe' => null,
            'referensi_id' => null,
            'endpoint' => fake()->url(),
            'metode' => 'POST',
            'request_payload' => ['contoh' => 'payload'],
            'response_payload' => ['error' => 'Timeout'],
            'status_code' => 500,
            'level' => 'error',
            'pesan_error' => fake()->sentence(),
            'status_resolusi' => 'open',
            'catatan_resolusi' => null,
            'resolved_by' => null,
            'resolved_at' => null,
        ];
    }
}
