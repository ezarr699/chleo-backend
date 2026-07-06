<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Test > Feature
 * @file        PasienTest.php
 * @path        app/Modules/Pasien/Tests/Feature/PasienTest.php
 * @description Test HTTP endpoint Pasien: CRUD dasar, verifikasi
 *              (upload foto, dengan/tanpa BPJS & asuransi opsional),
 *              toggle status aktif/nonaktif, soft delete, permission
 *              (pasien.manage vs pasien.verifikasi terpisah), 401/403.
 * @covers      app/Modules/Pasien/Controllers/PasienController.php
 * @covers      app/Modules/Pasien/Services/PasienService.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use App\Models\Asuransi;
use App\Models\GolonganDarah;
use App\Models\JenisKelamin;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Modules\Permission\Database\Seeders\RolesAndPermissionsSeeder;
use App\Modules\Tenancy\Tests\Concerns\WithTenant;

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

function validPasienPayload(array $overrides = []): array
{
    return array_merge([
        'nik' => '1234567890123456',
        'nama' => 'Budi Santoso',
        'tanggal_lahir' => '1990-05-10',
    ], $overrides);
}

it('lists pasien paginated', function () {
    $this->asTenant(fn () => Pasien::factory()->count(3)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/pasien')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data', 'meta' => ['current_page', 'per_page', 'total']])
        ->assertJsonCount(3, 'data');
});

it('creates pasien successfully with belum_verifikasi status', function () {
    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/pasien', validPasienPayload(['jenis_kelamin_id' => $jenisKelamin->id]))
        ->assertStatus(201)
        ->assertJsonPath('data.nama', 'Budi Santoso')
        ->assertJsonPath('data.status', 'belum_verifikasi');
});

it('returns 422 when nik is not 16 digits', function () {
    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/pasien', validPasienPayload([
            'nik' => '123',
            'jenis_kelamin_id' => $jenisKelamin->id,
        ]))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['nik']);
});

it('returns 422 when nik is a duplicate', function () {
    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());
    $this->asTenant(fn () => Pasien::factory()->create(['nik' => '1234567890123456', 'jenis_kelamin_id' => $jenisKelamin->id]));

    $this->actingAs($this->admin)
        ->postJson('http://acme.localhost/api/v1/pasien', validPasienPayload(['jenis_kelamin_id' => $jenisKelamin->id]))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['nik']);
});

it('updates pasien basic fields', function () {
    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());
    $pasien = $this->asTenant(fn () => Pasien::factory()->create(['jenis_kelamin_id' => $jenisKelamin->id]));

    $this->actingAs($this->admin)
        ->putJson("http://acme.localhost/api/v1/pasien/{$pasien->id}", validPasienPayload([
            'nama' => 'Budi Santoso Update',
            'jenis_kelamin_id' => $jenisKelamin->id,
        ]))
        ->assertStatus(200)
        ->assertJsonPath('data.nama', 'Budi Santoso Update');
});

it('verifies pasien with photo upload and sets status to aktif', function () {
    Storage::fake('public');

    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());
    $golonganDarah = $this->asTenant(fn () => GolonganDarah::factory()->create());
    $pasien = $this->asTenant(fn () => Pasien::factory()->create(['jenis_kelamin_id' => $jenisKelamin->id]));

    $response = $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/pasien/{$pasien->id}/verifikasi", [
            'foto' => UploadedFile::fake()->image('foto.jpg'),
            'tempat_lahir' => 'Jakarta',
            'golongan_darah_id' => $golonganDarah->id,
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 1',
        ]);

    $response->assertStatus(200)
        ->assertJsonPath('data.status', 'aktif')
        ->assertJsonPath('data.tempat_lahir', 'Jakarta');

    expect($response->json('data.foto_url'))->not->toBeNull();

    $this->asTenant(function () use ($pasien) {
        $pasien->refresh();
        expect($pasien->verified_at)->not->toBeNull();
        Storage::disk('public')->assertExists($pasien->foto_path);
    });
});

it('verifies pasien without optional BPJS and asuransi fields', function () {
    Storage::fake('public');

    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());
    $golonganDarah = $this->asTenant(fn () => GolonganDarah::factory()->create());
    $pasien = $this->asTenant(fn () => Pasien::factory()->create(['jenis_kelamin_id' => $jenisKelamin->id]));

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/pasien/{$pasien->id}/verifikasi", [
            'foto' => UploadedFile::fake()->image('foto.jpg'),
            'tempat_lahir' => 'Bandung',
            'golongan_darah_id' => $golonganDarah->id,
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jl. Asia Afrika No. 1',
        ])
        ->assertStatus(200)
        ->assertJsonPath('data.bpjs_nomor', null)
        ->assertJsonCount(0, 'data.asuransi_list');
});

it('verifies pasien with optional BPJS and one asuransi tambahan entry', function () {
    Storage::fake('public');

    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());
    $golonganDarah = $this->asTenant(fn () => GolonganDarah::factory()->create());
    $asuransi = $this->asTenant(fn () => Asuransi::factory()->create());
    $pasien = $this->asTenant(fn () => Pasien::factory()->create(['jenis_kelamin_id' => $jenisKelamin->id]));

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/pasien/{$pasien->id}/verifikasi", [
            'foto' => UploadedFile::fake()->image('foto.jpg'),
            'tempat_lahir' => 'Surabaya',
            'golongan_darah_id' => $golonganDarah->id,
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jl. Pemuda No. 1',
            'bpjs_nomor' => '0001234567890',
            'bpjs_jenis_peserta' => 'PBI APBN',
            'bpjs_kelas' => 'Kelas 1',
            'asuransi' => [
                ['asuransi_id' => $asuransi->id, 'nomor_polis' => 'POL-001'],
            ],
        ])
        ->assertStatus(200)
        ->assertJsonPath('data.bpjs_nomor', '0001234567890')
        ->assertJsonCount(1, 'data.asuransi_list')
        ->assertJsonPath('data.asuransi_list.0.asuransi.id', $asuransi->id)
        ->assertJsonPath('data.asuransi_list.0.nomor_polis', 'POL-001');
});

it('verifies pasien with more than one asuransi tambahan entry', function () {
    Storage::fake('public');

    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());
    $golonganDarah = $this->asTenant(fn () => GolonganDarah::factory()->create());
    [$asuransiA, $asuransiB] = $this->asTenant(fn () => Asuransi::factory()->count(2)->create())->all();
    $pasien = $this->asTenant(fn () => Pasien::factory()->create(['jenis_kelamin_id' => $jenisKelamin->id]));

    $response = $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/pasien/{$pasien->id}/verifikasi", [
            'foto' => UploadedFile::fake()->image('foto.jpg'),
            'tempat_lahir' => 'Surabaya',
            'golongan_darah_id' => $golonganDarah->id,
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jl. Pemuda No. 1',
            'asuransi' => [
                ['asuransi_id' => $asuransiA->id, 'nomor_polis' => 'POL-001'],
                ['asuransi_id' => $asuransiB->id, 'nomor_polis' => 'POL-002'],
            ],
        ]);

    $response->assertStatus(200)->assertJsonCount(2, 'data.asuransi_list');

    $asuransiIds = collect($response->json('data.asuransi_list'))->pluck('asuransi.id')->all();
    expect($asuransiIds)->toEqualCanonicalizing([$asuransiA->id, $asuransiB->id]);
});

it('verifies pasien with wilayah administratif lengkap', function () {
    Storage::fake('public');

    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());
    $golonganDarah = $this->asTenant(fn () => GolonganDarah::factory()->create());
    $pasien = $this->asTenant(fn () => Pasien::factory()->create(['jenis_kelamin_id' => $jenisKelamin->id]));

    $provinsi = \App\Models\Provinsi::query()->first();
    $kabupaten = \App\Models\Kabupaten::query()->where('province_code', $provinsi->code)->first();
    $kecamatan = \App\Models\Kecamatan::query()->where('city_code', $kabupaten->code)->first();
    $kelurahan = \App\Models\Kelurahan::query()->where('district_code', $kecamatan->code)->first();

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/pasien/{$pasien->id}/verifikasi", [
            'foto' => UploadedFile::fake()->image('foto.jpg'),
            'tempat_lahir' => 'Jakarta',
            'golongan_darah_id' => $golonganDarah->id,
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 1',
            'provinsi_code' => $provinsi->code,
            'kabupaten_code' => $kabupaten->code,
            'kecamatan_code' => $kecamatan->code,
            'kelurahan_code' => $kelurahan->code,
        ])
        ->assertStatus(200)
        ->assertJsonPath('data.provinsi.code', $provinsi->code)
        ->assertJsonPath('data.kabupaten.code', $kabupaten->code)
        ->assertJsonPath('data.kecamatan.code', $kecamatan->code)
        ->assertJsonPath('data.kelurahan.code', $kelurahan->code);
});

it('verifies pasien without wilayah administratif karena tetap opsional', function () {
    Storage::fake('public');

    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());
    $golonganDarah = $this->asTenant(fn () => GolonganDarah::factory()->create());
    $pasien = $this->asTenant(fn () => Pasien::factory()->create(['jenis_kelamin_id' => $jenisKelamin->id]));

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/pasien/{$pasien->id}/verifikasi", [
            'foto' => UploadedFile::fake()->image('foto.jpg'),
            'tempat_lahir' => 'Jakarta',
            'golongan_darah_id' => $golonganDarah->id,
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 1',
        ])
        ->assertStatus(200)
        ->assertJsonPath('data.provinsi', null)
        ->assertJsonPath('data.kabupaten', null)
        ->assertJsonPath('data.kecamatan', null)
        ->assertJsonPath('data.kelurahan', null);
});

it('returns 422 when wilayah code does not exist', function () {
    Storage::fake('public');

    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());
    $golonganDarah = $this->asTenant(fn () => GolonganDarah::factory()->create());
    $pasien = $this->asTenant(fn () => Pasien::factory()->create(['jenis_kelamin_id' => $jenisKelamin->id]));

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/pasien/{$pasien->id}/verifikasi", [
            'foto' => UploadedFile::fake()->image('foto.jpg'),
            'tempat_lahir' => 'Jakarta',
            'golongan_darah_id' => $golonganDarah->id,
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 1',
            'provinsi_code' => 'ZZ',
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['provinsi_code']);
});

it('returns 422 when verification is missing required fields', function () {
    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());
    $pasien = $this->asTenant(fn () => Pasien::factory()->create(['jenis_kelamin_id' => $jenisKelamin->id]));

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/pasien/{$pasien->id}/verifikasi", [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['foto', 'tempat_lahir', 'golongan_darah_id', 'nomor_telepon', 'alamat']);
});

it('fails to set status when pasien has not been verified', function () {
    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());
    $pasien = $this->asTenant(fn () => Pasien::factory()->create(['jenis_kelamin_id' => $jenisKelamin->id]));

    $this->actingAs($this->admin)
        ->patchJson("http://acme.localhost/api/v1/pasien/{$pasien->id}/status", ['aktif' => true])
        ->assertStatus(422);
});

it('toggles pasien status between aktif and nonaktif after verification', function () {
    Storage::fake('public');

    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());
    $golonganDarah = $this->asTenant(fn () => GolonganDarah::factory()->create());
    $pasien = $this->asTenant(fn () => Pasien::factory()->create(['jenis_kelamin_id' => $jenisKelamin->id]));

    $this->actingAs($this->admin)->postJson("http://acme.localhost/api/v1/pasien/{$pasien->id}/verifikasi", [
        'foto' => UploadedFile::fake()->image('foto.jpg'),
        'tempat_lahir' => 'Jakarta',
        'golongan_darah_id' => $golonganDarah->id,
        'nomor_telepon' => '081234567890',
        'alamat' => 'Jl. Merdeka No. 1',
    ])->assertStatus(200);

    $this->actingAs($this->admin)
        ->patchJson("http://acme.localhost/api/v1/pasien/{$pasien->id}/status", ['aktif' => false])
        ->assertStatus(200)
        ->assertJsonPath('data.status', 'nonaktif');

    $this->actingAs($this->admin)
        ->patchJson("http://acme.localhost/api/v1/pasien/{$pasien->id}/status", ['aktif' => true])
        ->assertStatus(200)
        ->assertJsonPath('data.status', 'aktif');
});

it('soft deletes pasien', function () {
    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());
    $pasien = $this->asTenant(fn () => Pasien::factory()->create(['jenis_kelamin_id' => $jenisKelamin->id]));

    $this->actingAs($this->admin)
        ->deleteJson("http://acme.localhost/api/v1/pasien/{$pasien->id}")
        ->assertStatus(200);

    $this->asTenant(fn () => $this->assertSoftDeleted($pasien));
});

it('returns 403 when the user lacks the manage permission', function () {
    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());
    $user = $this->asTenant(fn () => User::factory()->create());

    $this->actingAs($user)
        ->postJson('http://acme.localhost/api/v1/pasien', validPasienPayload(['jenis_kelamin_id' => $jenisKelamin->id]))
        ->assertStatus(403);
});

it('returns 403 when the user lacks the verifikasi permission', function () {
    $jenisKelamin = $this->asTenant(fn () => JenisKelamin::factory()->create());
    $golonganDarah = $this->asTenant(fn () => GolonganDarah::factory()->create());
    $pasien = $this->asTenant(fn () => Pasien::factory()->create(['jenis_kelamin_id' => $jenisKelamin->id]));

    $user = $this->asTenant(function () {
        $user = User::factory()->create();
        $user->givePermissionTo('pasien.manage');

        return $user;
    });

    $this->actingAs($user)
        ->postJson("http://acme.localhost/api/v1/pasien/{$pasien->id}/verifikasi", [
            'foto' => UploadedFile::fake()->image('foto.jpg'),
            'tempat_lahir' => 'Jakarta',
            'golongan_darah_id' => $golonganDarah->id,
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 1',
        ])
        ->assertStatus(403);
});

it('returns 401 when unauthenticated', function () {
    $this->getJson('http://acme.localhost/api/v1/pasien')->assertStatus(401);
});
