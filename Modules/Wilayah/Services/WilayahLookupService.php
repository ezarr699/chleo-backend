<?php
/**
 * ============================================================
 * @module      Wilayah
 * @layer       Service
 * @file        WilayahLookupService.php
 * @path        Modules/Wilayah/Services/WilayahLookupService.php
 * @description Implementasi Shared\Contracts\WilayahLookupInterface —
 *              satu-satunya jalur modul lain (mis. Pasien) boleh menyentuh
 *              data wilayah, tanpa pernah mengimpor Model
 *              Provinsi/Kabupaten/Kecamatan/Kelurahan secara langsung.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Wilayah\Services;

use Modules\Shared\Contracts\WilayahLookupInterface;
use Modules\Wilayah\Models\Kabupaten;
use Modules\Wilayah\Models\Kecamatan;
use Modules\Wilayah\Models\Kelurahan;
use Modules\Wilayah\Models\Provinsi;

final class WilayahLookupService implements WilayahLookupInterface
{
    public function namaProvinsi(?string $code): ?string
    {
        if ($code === null) {
            return null;
        }

        return Provinsi::query()->where('code', $code)->value('name');
    }

    public function namaKabupaten(?string $code): ?string
    {
        if ($code === null) {
            return null;
        }

        return Kabupaten::query()->where('code', $code)->value('name');
    }

    public function namaKecamatan(?string $code): ?string
    {
        if ($code === null) {
            return null;
        }

        return Kecamatan::query()->where('code', $code)->value('name');
    }

    public function namaKelurahan(?string $code): ?string
    {
        if ($code === null) {
            return null;
        }

        return Kelurahan::query()->where('code', $code)->value('name');
    }

    public function kodeValid(?string $provinsiCode, ?string $kabupatenCode, ?string $kecamatanCode, ?string $kelurahanCode): bool
    {
        if ($provinsiCode !== null && ! Provinsi::query()->where('code', $provinsiCode)->exists()) {
            return false;
        }

        if ($kabupatenCode !== null && ! Kabupaten::query()->where('code', $kabupatenCode)->exists()) {
            return false;
        }

        if ($kecamatanCode !== null && ! Kecamatan::query()->where('code', $kecamatanCode)->exists()) {
            return false;
        }

        if ($kelurahanCode !== null && ! Kelurahan::query()->where('code', $kelurahanCode)->exists()) {
            return false;
        }

        return true;
    }

    /**
     * @param  array<int, string>  $codes
     * @return array<string, string>
     */
    public function namaBanyak(string $tingkat, array $codes): array
    {
        $codes = array_values(array_unique(array_filter($codes)));

        if ($codes === []) {
            return [];
        }

        $modelClass = match ($tingkat) {
            'provinsi' => Provinsi::class,
            'kabupaten' => Kabupaten::class,
            'kecamatan' => Kecamatan::class,
            'kelurahan' => Kelurahan::class,
            default => throw new \InvalidArgumentException("Tingkat wilayah tidak dikenal: {$tingkat}"),
        };

        return $modelClass::query()
            ->whereIn('code', $codes)
            ->pluck('name', 'code')
            ->all();
    }
}
