<?php
/**
 * ============================================================
 * @module      Wilayah
 * @layer       Service
 * @file        WilayahDeteksiService.php
 * @path        Modules/Wilayah/Services/WilayahDeteksiService.php
 * @description Deteksi provinsi/kabupaten/kecamatan/kelurahan dari
 *              koordinat (lat/lng) browser pengguna. Reverse-geocode lewat
 *              Nominatim (OpenStreetMap, gratis tanpa API key) untuk dapat
 *              NAMA wilayah, lalu dicocokkan ke data laravolt/indonesia di
 *              database central — Nominatim tidak tahu kode wilayah kita,
 *              cuma nama, dan formatnya tidak selalu sama persis (mis. ada/
 *              tidaknya prefix "Kabupaten"/"Kota"), jadi pencocokan dibuat
 *              toleran (LIKE, dengan prefix administratif dilucuti) dan
 *              berjenjang. Data tagging OSM untuk level provinsi Indonesia
 *              tidak konsisten — kadang field `state` kosong total (mis.
 *              DKI Jakarta), kadang nama provinsi nyasar ke field `country`
 *              (mis. Surabaya, `country` malah berisi "Jawa Timur" bukan
 *              "Indonesia"). Karena itu ada fallback: (1) field `country`
 *              dipakai sebagai kandidat provinsi kalau bukan literal
 *              "Indonesia", (2) kalau tetap tidak ada kandidat nama provinsi
 *              sama sekali, coba cocokkan kabupaten/kota TANPA scope provinsi
 *              dulu (nama kota biasanya unik, mis. "Jakarta Barat"), lalu
 *              provinsi diturunkan dari relasi kabupaten itu. Pola yang sama
 *              dipakai lagi di level kecamatan: titik-titik tertentu sama
 *              sekali tidak punya field setingkat kecamatan (`city_district`/
 *              `subdistrict`/`suburb`/`town`) walau field kelurahan
 *              (`village`/`neighbourhood`/`hamlet`) tetap ada — jadi kalau
 *              match kecamatan langsung gagal, coba cocokkan kelurahan
 *              TANPA scope kecamatan dulu (di-scope ke kabupaten saja lewat
 *              relasi), lalu kecamatan diturunkan dari relasi kelurahan itu.
 *              Fallback unscoped ini WAJIB hanya diterima kalau hasilnya
 *              UNIK (lihat `matchUniqueByName`) — nama kelurahan banyak
 *              yang sama di kecamatan berbeda dalam satu kabupaten (terbukti
 *              ada 2.000+ pasangan kabupaten+nama-kelurahan yang duplikat
 *              di data laravolt/indonesia), jadi asal ambil hasil pertama
 *              berisiko nyasar ke kecamatan yang SALAH — lebih baik kosong
 *              (diisi manual) daripada salah tapi terlihat yakin.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://nominatim.org/release-docs/latest/api/Reverse/
 *              https://operations.osmfoundation.org/policies/nominatim/
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Wilayah\Services;

use Modules\Wilayah\Models\Kabupaten;
use Modules\Wilayah\Models\Kecamatan;
use Modules\Wilayah\Models\Kelurahan;
use Modules\Wilayah\Models\Provinsi;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class WilayahDeteksiService
{
    private const ADMIN_PREFIXES = ['kabupaten administratif', 'kota administratif', 'kabupaten', 'kota', 'kecamatan', 'kelurahan', 'desa', 'kab.'];

    /**
     * @return array{provinsi: Provinsi|null, kabupaten: Kabupaten|null, kecamatan: Kecamatan|null, kelurahan: Kelurahan|null}
     */
    public function detect(float $lat, float $lng): array
    {
        $address = $this->reverseGeocode($lat, $lng);

        $result = ['provinsi' => null, 'kabupaten' => null, 'kecamatan' => null, 'kelurahan' => null];

        if ($address === null) {
            return $result;
        }

        $kabupatenName = $address['city'] ?? $address['county'] ?? $address['municipality'] ?? null;

        $provinsiName = $this->resolveProvinsiCandidate($address);
        $provinsi = $this->matchByName(Provinsi::query(), $provinsiName);
        $kabupaten = null;

        if ($provinsi !== null) {
            $kabupaten = $this->matchByName(
                Kabupaten::query()->where('province_code', $provinsi->code),
                $kabupatenName,
            );
        } else {
            // Tidak ada kandidat nama provinsi sama sekali (mis. DKI Jakarta).
            // Cari kabupaten/kota tanpa scope provinsi, lalu turunkan provinsi-nya.
            $kabupaten = $this->matchByName(Kabupaten::query(), $kabupatenName);
            if ($kabupaten !== null) {
                $provinsi = Provinsi::query()->where('code', $kabupaten->province_code)->first();
            }
        }

        $result['provinsi'] = $provinsi;
        if ($provinsi === null) {
            return $result;
        }

        $result['kabupaten'] = $kabupaten;
        if ($kabupaten === null) {
            return $result;
        }

        $kecamatanName = $address['city_district'] ?? $address['subdistrict'] ?? $address['suburb'] ?? $address['town'] ?? null;
        $kelurahanName = $address['village'] ?? $address['neighbourhood'] ?? $address['hamlet'] ?? null;

        $kecamatan = $this->matchByName(
            Kecamatan::query()->where('city_code', $kabupaten->code),
            $kecamatanName,
        );
        $kelurahan = null;

        if ($kecamatan !== null) {
            $kelurahan = $this->matchByName(
                Kelurahan::query()->where('district_code', $kecamatan->code),
                $kelurahanName,
            );
        } else {
            // Tidak ada kandidat nama kecamatan sama sekali. Cari kelurahan
            // tanpa scope kecamatan (di-scope ke kabupaten lewat relasi),
            // lalu turunkan kecamatan-nya — simetris dengan fallback provinsi.
            // Wajib unik (lihat catatan kelas) — nama kelurahan sering kembar
            // di kecamatan lain dalam kabupaten yang sama.
            $kelurahan = $this->matchUniqueByName(
                Kelurahan::query()->whereHas('kecamatan', fn ($q) => $q->where('city_code', $kabupaten->code)),
                $kelurahanName,
            );
            if ($kelurahan !== null) {
                $kecamatan = $kelurahan->kecamatan;
            }
        }

        $result['kecamatan'] = $kecamatan;
        $result['kelurahan'] = $kelurahan;

        return $result;
    }

    /** @param array<string, string> $address */
    private function resolveProvinsiCandidate(array $address): ?string
    {
        if (! empty($address['state'])) {
            return $address['state'];
        }

        // OSM/Nominatim kadang salah label: nama provinsi muncul di field
        // `country` alih-alih `state` (lihat catatan kelas di atas).
        if (! empty($address['country']) && strcasecmp($address['country'], 'Indonesia') !== 0) {
            return $address['country'];
        }

        return null;
    }

    /** @return array<string, string>|null */
    private function reverseGeocode(float $lat, float $lng): ?array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Chleo-Clinic-App/1.0 (clinic patient address lookup)',
            ])
                // base_path(), bukan storage_path() — storage_path() disisipi
                // suffix per-tenant oleh FilesystemTenancyBootstrapper, padahal
                // cacert.pem ini aset global, bukan data tenant.
                ->withOptions(['verify' => base_path('storage/certs/cacert.pem')])
                ->timeout(5)
                ->get('https://nominatim.openstreetmap.org/reverse', [
                    'format' => 'json',
                    'lat' => $lat,
                    'lon' => $lng,
                    'addressdetails' => 1,
                    'zoom' => 18,
                ]);

            if (! $response->successful()) {
                return null;
            }

            return $response->json('address');
        } catch (\Throwable $e) {
            Log::warning('Reverse geocode lookup gagal.', ['error' => $e->getMessage()]);

            return null;
        }
    }

    /**
     * @template TModel of \Illuminate\Database\Eloquent\Model
     * @param  \Illuminate\Database\Eloquent\Builder<TModel>  $query
     * @return TModel|null
     */
    private function matchByName(\Illuminate\Database\Eloquent\Builder $query, ?string $name): ?object
    {
        if ($name === null || trim($name) === '') {
            return null;
        }

        $normalized = $this->stripAdminPrefix($name);

        return (clone $query)->whereRaw('LOWER(name) = ?', [strtolower($normalized)])->first()
            ?? (clone $query)->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($normalized).'%'])->first();
    }

    /**
     * Sama seperti `matchByName`, tapi cuma menerima hasil yang BENAR-BENAR
     * unik (persis 1 baris cocok). Dipakai untuk fallback unscoped yang
     * rawan tabrakan nama (lihat catatan kelas) — ambigu dianggap "tidak
     * ketemu", bukan menebak salah satu secara asal.
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model
     * @param  \Illuminate\Database\Eloquent\Builder<TModel>  $query
     * @return TModel|null
     */
    private function matchUniqueByName(\Illuminate\Database\Eloquent\Builder $query, ?string $name): ?object
    {
        if ($name === null || trim($name) === '') {
            return null;
        }

        $normalized = $this->stripAdminPrefix($name);

        $exact = (clone $query)->whereRaw('LOWER(name) = ?', [strtolower($normalized)])->get();
        if ($exact->count() === 1) {
            return $exact->first();
        }
        if ($exact->count() > 1) {
            return null;
        }

        $like = (clone $query)->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($normalized).'%'])->get();

        return $like->count() === 1 ? $like->first() : null;
    }

    private function stripAdminPrefix(string $name): string
    {
        $normalized = trim($name);

        foreach (self::ADMIN_PREFIXES as $prefix) {
            if (stripos($normalized, $prefix.' ') === 0) {
                $normalized = trim(substr($normalized, strlen($prefix) + 1));
                break;
            }
        }

        return $normalized;
    }
}
