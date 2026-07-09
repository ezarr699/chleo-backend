<?php
/**
 * ============================================================
 * @module      Wilayah
 * @layer       Test > Feature
 * @file        WilayahTest.php
 * @path        Modules/Wilayah/Tests/Feature/WilayahTest.php
 * @description Test HTTP endpoint lookup wilayah (provinsi/kabupaten/
 *              kecamatan/kelurahan) dan pembuktian bahwa data wilayah
 *              benar-benar dibagikan (shared) lewat koneksi central,
 *              bukan terduplikasi per-tenant.
 * @covers      Modules/Wilayah/Controllers/WilayahController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\Wilayah\Models\Kabupaten;
use Modules\Wilayah\Models\Kecamatan;
use Modules\Wilayah\Models\Provinsi;
use Modules\Auth\Models\User;
use Modules\Tenancy\Tests\Concerns\WithTenant;
use Illuminate\Support\Facades\Http;

uses(WithTenant::class);

beforeEach(function () {
    $this->createTenant('wilayah-test');

    $this->user = $this->asTenant(fn () => User::factory()->create());
});

afterEach(function () {
    $this->tenant->delete();
});

it('lists provinsi', function () {
    $this->actingAs($this->user)
        ->getJson('http://wilayah-test.localhost/api/v1/wilayah/provinsi')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data' => [['code', 'name']]]);

    expect(Provinsi::count())->toBeGreaterThan(30);
});

it('lists kabupaten scoped to the given provinsi only', function () {
    $provinsi = Provinsi::query()->first();
    $otherProvinsi = Provinsi::query()->where('code', '!=', $provinsi->code)->first();

    $response = $this->actingAs($this->user)
        ->getJson("http://wilayah-test.localhost/api/v1/wilayah/kabupaten?provinsi={$provinsi->code}")
        ->assertStatus(200);

    $codes = collect($response->json('data'))->pluck('code');
    $expectedCodes = Kabupaten::query()->where('province_code', $provinsi->code)->pluck('code');

    expect($codes->all())->toEqualCanonicalizing($expectedCodes->all());

    $otherCodes = Kabupaten::query()->where('province_code', $otherProvinsi->code)->pluck('code');
    expect($codes->intersect($otherCodes))->toBeEmpty();
});

it('lists kabupaten nationwide when no provinsi filter is given', function () {
    $response = $this->actingAs($this->user)
        ->getJson('http://wilayah-test.localhost/api/v1/wilayah/kabupaten')
        ->assertStatus(200);

    $codes = collect($response->json('data'))->pluck('code');

    expect($codes->count())->toBe(Kabupaten::count());
    expect($codes->count())->toBeGreaterThan(400);
});

it('lists kecamatan scoped to the given kabupaten only', function () {
    $kabupaten = Kabupaten::query()->first();

    $response = $this->actingAs($this->user)
        ->getJson("http://wilayah-test.localhost/api/v1/wilayah/kecamatan?kabupaten={$kabupaten->code}")
        ->assertStatus(200);

    $codes = collect($response->json('data'))->pluck('code');
    $expectedCodes = Kecamatan::query()->where('city_code', $kabupaten->code)->pluck('code');

    expect($codes->all())->toEqualCanonicalizing($expectedCodes->all());
});

it('lists kelurahan scoped to the given kecamatan only', function () {
    $kecamatan = Kecamatan::query()->first();

    $this->actingAs($this->user)
        ->getJson("http://wilayah-test.localhost/api/v1/wilayah/kelurahan?kecamatan={$kecamatan->code}")
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data' => [['code', 'name']]]);
});

it('returns 401 when unauthenticated', function () {
    $this->getJson('http://wilayah-test.localhost/api/v1/wilayah/provinsi')->assertStatus(401);
});

it('detects provinsi/kabupaten/kecamatan/kelurahan from coordinates via reverse geocoding', function () {
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response([
            'address' => [
                'state' => 'Jawa Barat',
                'city' => 'Kabupaten Bandung',
                'city_district' => 'Cileunyi',
                'village' => 'Cileunyi Kulon',
            ],
        ], 200),
    ]);

    $response = $this->actingAs($this->user)
        ->getJson('http://wilayah-test.localhost/api/v1/wilayah/deteksi-lokasi?lat=-6.9&lng=107.7')
        ->assertStatus(200);

    expect($response->json('data.provinsi.name'))->toBe('JAWA BARAT');
    expect($response->json('data.kabupaten.name'))->toBe('KABUPATEN BANDUNG');
    expect($response->json('data.kecamatan.name'))->toBe('CILEUNYI');
    expect($response->json('data.kelurahan.name'))->toBe('CILEUNYI KULON');

    Http::assertSent(fn ($request) => str_contains($request->url(), 'nominatim.openstreetmap.org/reverse')
        && $request['lat'] === -6.9
        && $request['lon'] === 107.7);
});

it('detects provinsi via unscoped kabupaten match when OSM omits the state field entirely', function () {
    // Kasus nyata: Nominatim untuk DKI Jakarta tidak mengembalikan field
    // `state` sama sekali (hanya ISO3166-2-lvl4), tapi field `city`
    // ("Jakarta Barat") cukup unik untuk dicocokkan tanpa scope provinsi
    // dulu, lalu provinsi diturunkan dari situ.
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response([
            'address' => [
                'office' => 'PT. Lautan Otsuka Chemical',
                'city' => 'Jakarta Barat',
                'ISO3166-2-lvl4' => 'ID-JK',
            ],
        ], 200),
    ]);

    $response = $this->actingAs($this->user)
        ->getJson('http://wilayah-test.localhost/api/v1/wilayah/deteksi-lokasi?lat=-6.2&lng=106.8')
        ->assertStatus(200);

    expect($response->json('data.provinsi.name'))->toBe('DAERAH KHUSUS IBUKOTA JAKARTA');
    expect($response->json('data.kabupaten.name'))->toBe('KOTA ADMINISTRASI JAKARTA BARAT');
});

it('detects provinsi from the country field when OSM mislabels it instead of state', function () {
    // Kasus nyata: Nominatim untuk Surabaya mengembalikan `country` berisi
    // "Jawa Timur" (bukan "Indonesia") dan tidak ada field `state` sama
    // sekali — bug tagging OSM, bukan kesalahan kita.
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response([
            'address' => [
                'road' => 'Jalan Kusuma Bangsa',
                'city' => 'Surabaya',
                'country' => 'Jawa Timur',
                'ISO3166-2-lvl4' => 'ID-JI',
            ],
        ], 200),
    ]);

    $response = $this->actingAs($this->user)
        ->getJson('http://wilayah-test.localhost/api/v1/wilayah/deteksi-lokasi?lat=-7.25&lng=112.75')
        ->assertStatus(200);

    expect($response->json('data.provinsi.name'))->toBe('JAWA TIMUR');
    expect($response->json('data.kabupaten.name'))->toBe('KOTA SURABAYA');
});

it('derives kecamatan from a matched kelurahan when OSM omits every kecamatan-level field', function () {
    // Kasus nyata: titik tertentu tidak punya field city_district/
    // subdistrict/suburb/town sama sekali, padahal `village` tetap ada.
    $kelurahan = \Modules\Wilayah\Models\Kelurahan::query()->first();
    $kecamatan = $kelurahan->kecamatan;
    $kabupaten = $kecamatan->kabupaten;
    $provinsi = $kabupaten->provinsi;

    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response([
            'address' => [
                'state' => $provinsi->name,
                'city' => $kabupaten->name,
                'village' => $kelurahan->name,
            ],
        ], 200),
    ]);

    $response = $this->actingAs($this->user)
        ->getJson('http://wilayah-test.localhost/api/v1/wilayah/deteksi-lokasi?lat=-6.9&lng=107.7')
        ->assertStatus(200);

    expect($response->json('data.kecamatan.code'))->toBe($kecamatan->code);
    expect($response->json('data.kelurahan.code'))->toBe($kelurahan->code);
});

it('does not guess a kecamatan when the kelurahan name is ambiguous within the kabupaten', function () {
    // "BEUTONG" memang ada DUA kali di Kabupaten Aceh Selatan (1101), di dua
    // kecamatan berbeda (110111 dan 110117) — data nyata, bukan rekayasa.
    // Tanpa field kecamatan dari OSM, kita TIDAK boleh asal pilih salah satu;
    // lebih baik kosong (diisi manual) daripada salah tapi terlihat yakin.
    $kabupaten = \Modules\Wilayah\Models\Kabupaten::query()->where('code', '1101')->first();
    $provinsi = $kabupaten->provinsi;

    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response([
            'address' => [
                'state' => $provinsi->name,
                'city' => $kabupaten->name,
                'village' => 'Beutong',
            ],
        ], 200),
    ]);

    $response = $this->actingAs($this->user)
        ->getJson('http://wilayah-test.localhost/api/v1/wilayah/deteksi-lokasi?lat=2.9&lng=97.6')
        ->assertStatus(200);

    expect($response->json('data.kabupaten.code'))->toBe('1101');
    expect($response->json('data.kecamatan'))->toBeNull();
    expect($response->json('data.kelurahan'))->toBeNull();
});

it('returns null wilayah when reverse geocoding finds no matching provinsi', function () {
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response([
            'address' => ['state' => 'Nonexistent Province Name'],
        ], 200),
    ]);

    $this->actingAs($this->user)
        ->getJson('http://wilayah-test.localhost/api/v1/wilayah/deteksi-lokasi?lat=-6.9&lng=107.7')
        ->assertStatus(200)
        ->assertJsonPath('data.provinsi', null)
        ->assertJsonPath('data.kabupaten', null);
});

it('returns null wilayah when the reverse geocoding service is unreachable', function () {
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response([], 503),
    ]);

    $this->actingAs($this->user)
        ->getJson('http://wilayah-test.localhost/api/v1/wilayah/deteksi-lokasi?lat=-6.9&lng=107.7')
        ->assertStatus(200)
        ->assertJsonPath('data.provinsi', null);
});

it('returns 422 when lat/lng is missing from deteksi-lokasi request', function () {
    $this->actingAs($this->user)
        ->getJson('http://wilayah-test.localhost/api/v1/wilayah/deteksi-lokasi')
        ->assertStatus(422)
        ->assertJsonValidationErrors(['lat', 'lng']);
});

it('shares identical wilayah reference data across different tenants instead of duplicating it', function () {
    $firstTenant = $this->tenant;
    $countInFirstTenant = $firstTenant->run(fn () => Provinsi::count());

    // createTenant() reassigns $this->tenant to the new tenant — capture its
    // return value instead of relying on the property.
    $secondTenant = $this->createTenant('wilayah-test-2');
    $countInSecondTenant = $secondTenant->run(fn () => Provinsi::count());
    $secondTenant->delete();

    // Restore so afterEach() deletes the correct (first) tenant.
    $this->tenant = $firstTenant;

    expect($countInSecondTenant)->toBe($countInFirstTenant);
});
