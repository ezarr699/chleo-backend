<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Test > Feature
 * @file        RegistrasiTest.php
 * @path        Modules/Registrasi/Tests/Feature/RegistrasiTest.php
 * @description Test HTTP endpoint Registrasi/Kunjungan: walk-in create,
 *              rujukan masuk/keluar (REG-01-2), online booking Mobile
 *              JKN/Web Portal + checkin (REG-01-3), penomoran urut
 *              (no_registrasi global & angka_antrian per poliklinik,
 *              reset per poliklinik berbeda), validasi gagal, profil_nakes
 *              tidak sesuai poliklinik, transisi status (checkin/panggil/
 *              selesai/batal/dirujuk) beserta aturan transisi yang tidak
 *              valid, permission (kunjungan.view vs kunjungan.manage),
 *              401/403/404.
 * @covers      Modules/Registrasi/Controllers/RegistrasiController.php
 * @covers      Modules/Registrasi/Services/RegistrasiService.php
 * @covers      Modules/Registrasi/Repositories/RegistrasiRepository.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\Registrasi\Models\Kunjungan;
use Modules\Pasien\Models\Pasien;
use Modules\Penjamin\Models\Penjamin;
use Modules\Poliklinik\Models\Poliklinik;
use Modules\Profesi\Models\Profesi;
use Modules\ProfilNakes\Models\ProfilNakes;
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

it('registers a walk-in kunjungan successfully', function () {
    [$pasien, $poliklinik, $penjamin] = $this->asTenant(fn () => [
        Pasien::factory()->create(),
        Poliklinik::factory()->create(),
        Penjamin::factory()->create(),
    ]);

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/kunjungan', [
            'pasien_id' => $pasien->id,
            'poliklinik_id' => $poliklinik->id,
            'penjamin_id' => $penjamin->id,
        ])
        ->assertStatus(201)
        ->assertJsonPath('data.cara_masuk', 'walk_in')
        ->assertJsonPath('data.status', 'menunggu')
        ->assertJsonPath('data.angka_antrian', 1)
        ->assertJsonPath('data.no_antrian', 'A-001')
        ->assertJsonPath('data.no_antrian_bpjs', null)
        ->assertJsonPath('data.no_kunjungan_bpjs', null)
        ->assertJsonPath('data.no_sep', null);
});

it('increments angka_antrian sequentially per poliklinik and resets for a different poliklinik', function () {
    [$pasien, $poliklinikA, $poliklinikB, $penjamin] = $this->asTenant(fn () => [
        Pasien::factory()->create(),
        Poliklinik::factory()->create(),
        Poliklinik::factory()->create(),
        Penjamin::factory()->create(),
    ]);

    $payload = fn (int $poliklinikId) => [
        'pasien_id' => $pasien->id,
        'poliklinik_id' => $poliklinikId,
        'penjamin_id' => $penjamin->id,
    ];

    $this->actingAs($this->admin)->postJson('http://acme.localhost/api/v1/kunjungan', $payload($poliklinikA->id))
        ->assertJsonPath('data.angka_antrian', 1)
        ->assertJsonPath('data.no_registrasi', 'REG-'.now()->format('Ymd').'-0001');

    $this->actingAs($this->admin)->postJson('http://acme.localhost/api/v1/kunjungan', $payload($poliklinikA->id))
        ->assertJsonPath('data.angka_antrian', 2)
        ->assertJsonPath('data.no_registrasi', 'REG-'.now()->format('Ymd').'-0002');

    // Poliklinik berbeda -> angka_antrian mulai dari 1 lagi, tapi no_registrasi (global) tetap lanjut.
    $this->actingAs($this->admin)->postJson('http://acme.localhost/api/v1/kunjungan', $payload($poliklinikB->id))
        ->assertJsonPath('data.angka_antrian', 1)
        ->assertJsonPath('data.no_antrian', 'A-001')
        ->assertJsonPath('data.no_registrasi', 'REG-'.now()->format('Ymd').'-0003');
});

it('uses poliklinik kode_bpjs as the no_antrian prefix when it is set', function () {
    [$pasien, $poliklinik, $penjamin] = $this->asTenant(fn () => [
        Pasien::factory()->create(),
        Poliklinik::factory()->create(['kode_bpjs' => 'UMU']),
        Penjamin::factory()->create(),
    ]);

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/kunjungan', [
            'pasien_id' => $pasien->id,
            'poliklinik_id' => $poliklinik->id,
            'penjamin_id' => $penjamin->id,
        ])
        ->assertJsonPath('data.no_antrian', 'UMU-001');
});

it('returns 422 when required fields are missing', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/kunjungan', [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['pasien_id', 'poliklinik_id', 'penjamin_id']);
});

it('returns 422 when profil_nakes does not practice at the chosen poliklinik', function () {
    [$pasien, $poliklinikA, $poliklinikB, $penjamin, $profesi] = $this->asTenant(fn () => [
        Pasien::factory()->create(),
        Poliklinik::factory()->create(),
        Poliklinik::factory()->create(),
        Penjamin::factory()->create(),
        Profesi::factory()->create(),
    ]);

    $nakes = $this->asTenant(fn () => ProfilNakes::factory()->create([
        'profesi_id' => $profesi->id,
        'poliklinik_id' => $poliklinikB->id,
    ]));

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/kunjungan', [
            'pasien_id' => $pasien->id,
            'poliklinik_id' => $poliklinikA->id,
            'profil_nakes_id' => $nakes->id,
            'penjamin_id' => $penjamin->id,
        ])
        ->assertStatus(422);
});

it('registers a rujukan masuk kunjungan successfully', function () {
    [$pasien, $poliklinik, $penjamin] = $this->asTenant(fn () => [
        Pasien::factory()->create(),
        Poliklinik::factory()->create(),
        Penjamin::factory()->create(),
    ]);

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/kunjungan/rujukan-masuk', [
            'pasien_id' => $pasien->id,
            'poliklinik_id' => $poliklinik->id,
            'penjamin_id' => $penjamin->id,
            'asal_faskes_kode' => 'FKTP001',
            'asal_faskes_nama' => 'Puskesmas Contoh',
            'diagnosa_rujukan' => 'Demam',
        ])
        ->assertStatus(201)
        ->assertJsonPath('data.cara_masuk', 'rujukan')
        ->assertJsonPath('data.status', 'menunggu')
        ->assertJsonPath('data.rujukan.0.arah', 'masuk')
        ->assertJsonPath('data.rujukan.0.asal_faskes_kode', 'FKTP001')
        ->assertJsonPath('data.rujukan.0.asal_faskes_nama', 'Puskesmas Contoh');
});

it('returns 422 when rujukan masuk is missing asal_faskes fields', function () {
    [$pasien, $poliklinik, $penjamin] = $this->asTenant(fn () => [
        Pasien::factory()->create(),
        Poliklinik::factory()->create(),
        Penjamin::factory()->create(),
    ]);

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/kunjungan/rujukan-masuk', [
            'pasien_id' => $pasien->id,
            'poliklinik_id' => $poliklinik->id,
            'penjamin_id' => $penjamin->id,
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['asal_faskes_kode', 'asal_faskes_nama']);
});

it('returns 403 when the user lacks the manage permission for rujukan masuk', function () {
    [$pasien, $poliklinik, $penjamin] = $this->asTenant(fn () => [
        Pasien::factory()->create(),
        Poliklinik::factory()->create(),
        Penjamin::factory()->create(),
    ]);

    $user = $this->asTenant(fn () => User::factory()->create());

    $this->actingAs($user)
        ->postJson('http://acme.localhost/api/v1/kunjungan/rujukan-masuk', [
            'pasien_id' => $pasien->id,
            'poliklinik_id' => $poliklinik->id,
            'penjamin_id' => $penjamin->id,
            'asal_faskes_kode' => 'FKTP001',
            'asal_faskes_nama' => 'Puskesmas Contoh',
        ])
        ->assertStatus(403);
});

it('refers an existing kunjungan out to another faskes', function () {
    $kunjungan = $this->asTenant(fn () => Kunjungan::factory()->create());

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/rujukan-keluar", [
            'tujuan_faskes_kode' => 'FKRTL001',
            'tujuan_faskes_nama' => 'RS Rujukan Contoh',
            'diagnosa_rujukan' => 'Perlu penanganan spesialis',
        ])
        ->assertStatus(200)
        ->assertJsonPath('data.status', 'dirujuk')
        ->assertJsonPath('data.rujukan.0.arah', 'keluar')
        ->assertJsonPath('data.rujukan.0.tujuan_faskes_kode', 'FKRTL001')
        ->assertJsonPath('data.rujukan.0.tujuan_faskes_nama', 'RS Rujukan Contoh');
});

it('returns 422 when rujukan keluar is missing tujuan_faskes fields', function () {
    $kunjungan = $this->asTenant(fn () => Kunjungan::factory()->create());

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/rujukan-keluar", [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['tujuan_faskes_kode', 'tujuan_faskes_nama']);
});

it('returns 422 when rujukan keluar is requested on a kunjungan that is already selesai', function () {
    $kunjungan = $this->asTenant(fn () => Kunjungan::factory()->create(['status' => 'selesai']));

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/rujukan-keluar", [
            'tujuan_faskes_kode' => 'FKRTL001',
            'tujuan_faskes_nama' => 'RS Rujukan Contoh',
        ])
        ->assertStatus(422);
});

it('creates an online booking with status terjadwal', function () {
    [$pasien, $poliklinik, $penjamin] = $this->asTenant(fn () => [
        Pasien::factory()->create(),
        Poliklinik::factory()->create(),
        Penjamin::factory()->create(),
    ]);

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/kunjungan/booking', [
            'pasien_id' => $pasien->id,
            'poliklinik_id' => $poliklinik->id,
            'penjamin_id' => $penjamin->id,
            'tanggal_kunjungan' => now()->addDay()->toDateString(),
            'sumber_booking' => 'mobile_jkn',
        ])
        ->assertStatus(201)
        ->assertJsonPath('data.cara_masuk', 'online_booking')
        ->assertJsonPath('data.sumber_booking', 'mobile_jkn')
        ->assertJsonPath('data.status', 'terjadwal');
});

it('returns 422 when booking tanggal_kunjungan is in the past', function () {
    [$pasien, $poliklinik, $penjamin] = $this->asTenant(fn () => [
        Pasien::factory()->create(),
        Poliklinik::factory()->create(),
        Penjamin::factory()->create(),
    ]);

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/kunjungan/booking', [
            'pasien_id' => $pasien->id,
            'poliklinik_id' => $poliklinik->id,
            'penjamin_id' => $penjamin->id,
            'tanggal_kunjungan' => now()->subDay()->toDateString(),
            'sumber_booking' => 'web_portal',
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['tanggal_kunjungan']);
});

it('returns 422 when booking sumber_booking is not a valid channel', function () {
    [$pasien, $poliklinik, $penjamin] = $this->asTenant(fn () => [
        Pasien::factory()->create(),
        Poliklinik::factory()->create(),
        Penjamin::factory()->create(),
    ]);

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/kunjungan/booking', [
            'pasien_id' => $pasien->id,
            'poliklinik_id' => $poliklinik->id,
            'penjamin_id' => $penjamin->id,
            'tanggal_kunjungan' => now()->addDay()->toDateString(),
            'sumber_booking' => 'sms',
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['sumber_booking']);
});

it('checks in a booking and moves it into the queue', function () {
    $kunjungan = $this->asTenant(fn () => Kunjungan::factory()->create([
        'cara_masuk' => 'online_booking',
        'sumber_booking' => 'mobile_jkn',
        'status' => 'terjadwal',
    ]));

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/checkin")
        ->assertStatus(200)
        ->assertJsonPath('data.status', 'menunggu');
});

it('returns 422 when checkin is requested on a kunjungan that is not terjadwal', function () {
    $kunjungan = $this->asTenant(fn () => Kunjungan::factory()->create(['status' => 'menunggu']));

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/checkin")
        ->assertStatus(422);
});

it('calls, then finishes a kunjungan', function () {
    $kunjungan = $this->asTenant(fn () => Kunjungan::factory()->create());

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/panggil")
        ->assertStatus(200)
        ->assertJsonPath('data.status', 'dipanggil');

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/selesai")
        ->assertStatus(200)
        ->assertJsonPath('data.status', 'selesai');
});

it('returns 422 when calling a kunjungan that is not in menunggu status', function () {
    $kunjungan = $this->asTenant(fn () => Kunjungan::factory()->create(['status' => 'selesai']));

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/panggil")
        ->assertStatus(422);
});

it('cancels a kunjungan with a reason', function () {
    $kunjungan = $this->asTenant(fn () => Kunjungan::factory()->create());

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/batal", [
            'alasan_batal' => 'Pasien membatalkan diri',
        ])
        ->assertStatus(200)
        ->assertJsonPath('data.status', 'batal')
        ->assertJsonPath('data.alasan_batal', 'Pasien membatalkan diri');
});

it('returns 422 when cancelling requires alasan_batal', function () {
    $kunjungan = $this->asTenant(fn () => Kunjungan::factory()->create());

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/batal", [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['alasan_batal']);
});

it('returns 422 when cancelling a kunjungan that is already selesai', function () {
    $kunjungan = $this->asTenant(fn () => Kunjungan::factory()->create(['status' => 'selesai']));

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/kunjungan/{$kunjungan->id}/batal", [
            'alasan_batal' => 'Coba batalkan setelah selesai',
        ])
        ->assertStatus(422);
});

it('lists kunjungan paginated', function () {
    $this->asTenant(fn () => Kunjungan::factory()->count(3)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/kunjungan')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data', 'meta' => ['current_page', 'per_page', 'total']])
        ->assertJsonCount(3, 'data');
});

it('returns 404 when kunjungan is not found', function () {
    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/kunjungan/999999')
        ->assertStatus(404);
});

it('returns 403 when the user lacks the manage permission', function () {
    [$pasien, $poliklinik, $penjamin] = $this->asTenant(fn () => [
        Pasien::factory()->create(),
        Poliklinik::factory()->create(),
        Penjamin::factory()->create(),
    ]);

    $user = $this->asTenant(fn () => User::factory()->create());

    $this->actingAs($user)
        ->postJson('http://acme.localhost/api/v1/kunjungan', [
            'pasien_id' => $pasien->id,
            'poliklinik_id' => $poliklinik->id,
            'penjamin_id' => $penjamin->id,
        ])
        ->assertStatus(403);
});

it('returns 401 when unauthenticated', function () {
    $this->getJson('http://acme.localhost/api/v1/kunjungan')->assertStatus(401);
});
