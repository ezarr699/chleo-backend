<?php
/**
 * ============================================================
 * @module      RawatJalan
 * @layer       Database > Factory
 * @file        PemeriksaanDiagnosisFactory.php
 * @path        database/factories/PemeriksaanDiagnosisFactory.php
 * @description Factory untuk data testing model PemeriksaanDiagnosis.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Icd10\Models\Icd10;
use Modules\RawatJalan\Models\Pemeriksaan;
use Modules\RawatJalan\Models\PemeriksaanDiagnosis;

/**
 * @extends Factory<PemeriksaanDiagnosis>
 */
class PemeriksaanDiagnosisFactory extends Factory
{
    protected $model = PemeriksaanDiagnosis::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pemeriksaan_id' => Pemeriksaan::factory(),
            'icd10_id' => Icd10::factory(),
            'tipe' => 'utama',
            'catatan' => null,
        ];
    }
}
