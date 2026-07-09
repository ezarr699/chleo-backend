<?php
/**
 * ============================================================
 * @module      Jkn
 * @layer       Test > Feature
 * @file        VClaimTest.php
 * @path        Modules/Jkn/Tests/Feature/VClaimTest.php
 * @description Test HTTP endpoint bridging V-Claim BPJS (JKN-01-2):
 *              cek eligibilitas peserta & buat SEP, validasi gagal,
 *              permission (bpjs_vclaim.view vs bpjs_vclaim.manage),
 *              401/403. VClaimService (concrete, tanpa interface) di-mock
 *              lewat container (bukan memanggil BPJS asli) — kredensial
 *              BPJS belum tersedia di lingkungan ini, jadi test ini murni
 *              memverifikasi routing/validasi/permission/response
 *              shape, bukan koneksi V-Claim yang sesungguhnya.
 * @covers      Modules/Jkn/Controllers/VClaimController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\Auth\Models\User;
use Modules\Jkn\Services\VClaimService;
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

it('checks BPJS peserta eligibility', function () {
    $this->mock(VClaimService::class, function ($mock) {
        $mock->shouldReceive('cekEligibilitasPeserta')
            ->once()
            ->with('0001234567890', '2026-07-08')
            ->andReturn(['nama' => 'Budi', 'nik' => '3201010101010001']);
    });

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/bpjs/peserta?no_kartu=0001234567890&tanggal_sep=2026-07-08')
        ->assertStatus(200)
        ->assertJsonPath('data.nama', 'Budi');
});

it('returns 422 when eligibilitas check is missing required fields', function () {
    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/bpjs/peserta')
        ->assertStatus(422)
        ->assertJsonValidationErrors(['no_kartu', 'tanggal_sep']);
});

it('returns 403 when the user lacks the view permission for eligibilitas', function () {
    $user = $this->asTenant(fn () => User::factory()->create());

    $this->actingAs($user)
        ->getJson('http://acme.localhost/api/v1/bpjs/peserta?no_kartu=0001234567890&tanggal_sep=2026-07-08')
        ->assertStatus(403);
});

it('returns 401 when unauthenticated', function () {
    $this->getJson('http://acme.localhost/api/v1/bpjs/peserta?no_kartu=0001234567890&tanggal_sep=2026-07-08')
        ->assertStatus(401);
});

it('creates a SEP for an existing kunjungan', function () {
    $this->mock(VClaimService::class, function ($mock) {
        $mock->shouldReceive('buatSep')
            ->once()
            ->with(1, Mockery::on(fn ($data) => $data['no_kartu'] === '0001234567890'))
            ->andReturn([
                'kunjungan_id' => 1,
                'no_registrasi' => 'REG-20260708-0001',
                'no_sep' => 'SEP-001',
                'status' => 'menunggu',
            ]);
    });

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/kunjungan/1/sep', [
            'no_kartu' => '0001234567890',
            'tanggal_sep' => '2026-07-08',
            'ppk_pelayanan' => '0001R001',
            'jenis_pelayanan' => 'rawat_jalan',
            'poli_tujuan' => 'INT',
        ])
        ->assertStatus(201)
        ->assertJsonPath('data.no_sep', 'SEP-001');
});

it('returns 422 when SEP payload is missing required fields', function () {
    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/kunjungan/1/sep', [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['no_kartu', 'tanggal_sep', 'ppk_pelayanan', 'jenis_pelayanan', 'poli_tujuan']);
});

it('returns 403 when the user lacks the manage permission for buatSep', function () {
    $user = $this->asTenant(fn () => User::factory()->create());

    $this->actingAs($user)
        ->postJson('http://acme.localhost/api/v1/kunjungan/1/sep', [
            'no_kartu' => '0001234567890',
            'tanggal_sep' => '2026-07-08',
            'ppk_pelayanan' => '0001R001',
            'jenis_pelayanan' => 'rawat_jalan',
            'poli_tujuan' => 'INT',
        ])
        ->assertStatus(403);
});
