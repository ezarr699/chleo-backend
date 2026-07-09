<?php
/**
 * ============================================================
 * @module      RawatJalan
 * @layer       Test > Feature
 * @file        RawatJalanTest.php
 * @path        Modules/RawatJalan/Tests/Feature/RawatJalanTest.php
 * @description Test HTTP endpoint Pemeriksaan (SOAP, RWJ-01-1): create
 *              sukses dengan Assessment (diagnosis ICD-10), validasi
 *              status kunjungan, satu kunjungan cuma boleh satu
 *              pemeriksaan, aturan tepat satu diagnosis utama, update
 *              (replace diagnosis), 404/403/401.
 * @covers      Modules/RawatJalan/Controllers/RawatJalanController.php
 * @covers      Modules/RawatJalan/Services/RawatJalanService.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\Icd10\Models\Icd10;
use Modules\Registrasi\Models\Kunjungan;
use Modules\ProfilNakes\Models\ProfilNakes;
use Modules\RawatJalan\Models\Pemeriksaan;
use Modules\Auth\Models\User;
use Modules\Permission\Database\Seeders\RolesAndPermissionsSeeder;
use Modules\Tenancy\Tests\Concerns\WithTenant;

uses(WithTenant::class);

beforeEach(function () {
    $this->createTenant('acme');

    $this->admin = $this->asTenant(function () {
        (new RolesAndPermissionsSeeder())->run();

        $user = User::factory()->create();
        $user->assignRole('admin');

        return $user;
    });
});

afterEach(function () {
    $this->tenant->delete();
});

it('creates a pemeriksaan with SOAP + Assessment for a dipanggil kunjungan', function () {
    [$kunjungan, $nakes, $icd10Utama, $icd10Sekunder] = $this->asTenant(fn () => [
        Kunjungan::factory()->create(['status' => 'dipanggil']),
        ProfilNakes::factory()->create(),
        Icd10::factory()->create(['kode' => 'J00', 'deskripsi' => 'Nasofaringitis akut']),
        Icd10::factory()->create(['kode' => 'R50.9', 'deskripsi' => 'Demam']),
    ]);

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/pemeriksaan", [
            'profil_nakes_id' => $nakes->id,
            'subjektif' => 'Batuk pilek 3 hari',
            'tekanan_darah_sistolik' => 120,
            'tekanan_darah_diastolik' => 80,
            'nadi' => 88,
            'suhu' => 37.2,
            'rencana' => 'Istirahat, obat simptomatik',
            'diagnosis' => [
                ['icd10_id' => $icd10Utama->id, 'tipe' => 'utama'],
                ['icd10_id' => $icd10Sekunder->id, 'tipe' => 'sekunder', 'catatan' => 'Demam ringan'],
            ],
        ])
        ->assertStatus(201)
        ->assertJsonPath('data.subjektif', 'Batuk pilek 3 hari')
        ->assertJsonPath('data.objektif.nadi', 88)
        ->assertJsonCount(2, 'data.diagnosis')
        ->assertJsonPath('data.diagnosis.0.icd10.kode', 'J00');
});

it('returns 422 when kunjungan status is not dipanggil', function () {
    [$kunjungan, $nakes, $icd10] = $this->asTenant(fn () => [
        Kunjungan::factory()->create(['status' => 'menunggu']),
        ProfilNakes::factory()->create(),
        Icd10::factory()->create(),
    ]);

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/pemeriksaan", [
            'profil_nakes_id' => $nakes->id,
            'diagnosis' => [['icd10_id' => $icd10->id, 'tipe' => 'utama']],
        ])
        ->assertStatus(422);
});

it('returns 422 when the kunjungan already has a pemeriksaan', function () {
    [$kunjungan, $nakes, $icd10] = $this->asTenant(function () {
        $kunjungan = Kunjungan::factory()->create(['status' => 'dipanggil']);
        Pemeriksaan::factory()->create([
            'kunjungan_id' => $kunjungan->id,
            'profil_nakes_id' => ProfilNakes::factory()->create()->id,
            'diperiksa_pada' => now(),
        ]);

        return [$kunjungan, ProfilNakes::factory()->create(), Icd10::factory()->create()];
    });

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/pemeriksaan", [
            'profil_nakes_id' => $nakes->id,
            'diagnosis' => [['icd10_id' => $icd10->id, 'tipe' => 'utama']],
        ])
        ->assertStatus(422);
});

it('returns 422 when there is no diagnosis marked utama', function () {
    [$kunjungan, $nakes, $icd10] = $this->asTenant(fn () => [
        Kunjungan::factory()->create(['status' => 'dipanggil']),
        ProfilNakes::factory()->create(),
        Icd10::factory()->create(),
    ]);

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/pemeriksaan", [
            'profil_nakes_id' => $nakes->id,
            'diagnosis' => [['icd10_id' => $icd10->id, 'tipe' => 'sekunder']],
        ])
        ->assertStatus(422);
});

it('returns 422 when there is more than one diagnosis marked utama', function () {
    [$kunjungan, $nakes, $icd10A, $icd10B] = $this->asTenant(fn () => [
        Kunjungan::factory()->create(['status' => 'dipanggil']),
        ProfilNakes::factory()->create(),
        Icd10::factory()->create(),
        Icd10::factory()->create(),
    ]);

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/pemeriksaan", [
            'profil_nakes_id' => $nakes->id,
            'diagnosis' => [
                ['icd10_id' => $icd10A->id, 'tipe' => 'utama'],
                ['icd10_id' => $icd10B->id, 'tipe' => 'utama'],
            ],
        ])
        ->assertStatus(422);
});

it('shows a pemeriksaan for a kunjungan', function () {
    $kunjungan = $this->asTenant(function () {
        $kunjungan = Kunjungan::factory()->create();
        Pemeriksaan::factory()->create([
            'kunjungan_id' => $kunjungan->id,
            'profil_nakes_id' => ProfilNakes::factory()->create()->id,
            'subjektif' => 'Keluhan pasien',
            'diperiksa_pada' => now(),
        ]);

        return $kunjungan;
    });

    $this->actingAs($this->admin)
        ->getJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/pemeriksaan")
        ->assertStatus(200)
        ->assertJsonPath('data.subjektif', 'Keluhan pasien');
});

it('returns 404 when the kunjungan has no pemeriksaan yet', function () {
    $kunjungan = $this->asTenant(fn () => Kunjungan::factory()->create());

    $this->actingAs($this->admin)
        ->getJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/pemeriksaan")
        ->assertStatus(404);
});

it('updates a pemeriksaan and replaces its diagnosis', function () {
    [$kunjungan, $icd10Baru] = $this->asTenant(function () {
        $kunjungan = Kunjungan::factory()->create();
        $nakes = ProfilNakes::factory()->create();
        $icd10Lama = Icd10::factory()->create();
        $pemeriksaan = Pemeriksaan::factory()->create([
            'kunjungan_id' => $kunjungan->id,
            'profil_nakes_id' => $nakes->id,
            'subjektif' => 'Lama',
            'diperiksa_pada' => now(),
        ]);
        $pemeriksaan->diagnosis()->create(['icd10_id' => $icd10Lama->id, 'tipe' => 'utama']);

        return [$kunjungan, Icd10::factory()->create()];
    });

    $this->actingAs($this->admin)
        ->putJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/pemeriksaan", [
            'subjektif' => 'Diperbarui',
            'diagnosis' => [['icd10_id' => $icd10Baru->id, 'tipe' => 'utama']],
        ])
        ->assertStatus(200)
        ->assertJsonPath('data.subjektif', 'Diperbarui')
        ->assertJsonCount(1, 'data.diagnosis')
        ->assertJsonPath('data.diagnosis.0.icd10.id', $icd10Baru->id);
});

it('returns 403 when the user lacks the manage permission', function () {
    [$kunjungan, $nakes, $icd10] = $this->asTenant(fn () => [
        Kunjungan::factory()->create(['status' => 'dipanggil']),
        ProfilNakes::factory()->create(),
        Icd10::factory()->create(),
    ]);
    $user = $this->asTenant(fn () => User::factory()->create());

    $this->actingAs($user)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/pemeriksaan", [
            'profil_nakes_id' => $nakes->id,
            'diagnosis' => [['icd10_id' => $icd10->id, 'tipe' => 'utama']],
        ])
        ->assertStatus(403);
});

it('returns 401 when unauthenticated', function () {
    $kunjungan = $this->asTenant(fn () => Kunjungan::factory()->create());

    $this->getJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/pemeriksaan")
        ->assertStatus(401);
});
