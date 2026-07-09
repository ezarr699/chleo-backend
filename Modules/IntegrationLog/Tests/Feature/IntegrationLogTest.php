<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Test > Feature
 * @file        IntegrationLogTest.php
 * @path        Modules/IntegrationLog/Tests/Feature/IntegrationLogTest.php
 * @description Test IntegrationLoggerInterface (jalur tulis dipakai modul
 *              bridging lain, INT-01-1) + notifikasi admin saat level
 *              'error' (INT-01-3), dan HTTP endpoint dashboard admin:
 *              list+filter, detail, investigate/resolve (INT-01-2)
 *              beserta aturan transisi yang tidak valid, permission
 *              (log_integrasi.view vs log_integrasi.manage), 401/403/404.
 * @covers      Modules/IntegrationLog/Services/IntegrationLoggerService.php
 * @covers      Modules/IntegrationLog/Services/IntegrationLogService.php
 * @covers      Modules/IntegrationLog/Controllers/IntegrationLogController.php
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

use Modules\IntegrationLog\Models\LogIntegrasi;
use Modules\Auth\Models\User;
use Modules\IntegrationLog\Notifications\IntegrationErrorDetected;
use Modules\Permission\Database\Seeders\RolesAndPermissionsSeeder;
use Modules\Shared\Contracts\IntegrationLoggerInterface;
use Modules\Tenancy\Tests\Concerns\WithTenant;
use Illuminate\Support\Facades\Notification;

uses(WithTenant::class);

beforeEach(function () {
    $this->createTenant('acme');

    $this->admin = $this->asTenant(function () {
        (new RolesAndPermissionsSeeder())->run();

        $user = User::factory()->create();
        $user->assignRole('admin');

        // Factory create() tidak lewat UserDirectoryService, jadi
        // UserCreatedOrUpdated tidak otomatis terpicu di sini — dispatch
        // manual supaya cache lokal IntegrationLog (resolved_by_nama)
        // terisi, persis seperti alur produksi.
        \App\Events\UserCreatedOrUpdated::dispatch($user->id, $user->name, $user->email);

        return $user;
    });
});

afterEach(function () {
    $this->tenant->delete();
});

it('logs an error via IntegrationLoggerInterface and notifies admins', function () {
    Notification::fake();

    $log = $this->asTenant(function () {
        app(IntegrationLoggerInterface::class)->log(
            'sisrute',
            'error',
            'Timeout menghubungi SISRUTE',
            [
                'referensi_tipe' => 'kunjungan_rujukan',
                'referensi_id' => 1,
                'endpoint' => 'https://sisrute.kemkes.go.id/rujukan',
                'metode' => 'POST',
                'status_code' => 504,
            ],
        );

        // IntegrationLoggerInterface::log() sengaja return void (lihat
        // Modules/Shared/Contracts/IntegrationLoggerInterface.php) supaya
        // pemanggil lintas modul tidak perlu kenal Model LogIntegrasi —
        // baris tercatat diambil ulang di sini karena test ini MILIK modul
        // IntegrationLog sendiri, jadi boleh kenal Model-nya langsung.
        return LogIntegrasi::query()->latest('id')->first();
    });

    expect($log)->toBeInstanceOf(LogIntegrasi::class)
        ->and($log->integrasi)->toBe('sisrute')
        ->and($log->level)->toBe('error')
        ->and($log->status_resolusi)->toBe('open');

    Notification::assertSentTo($this->admin, IntegrationErrorDetected::class);
});

it('does not notify admins when log level is not error', function () {
    Notification::fake();

    $this->asTenant(fn () => app(IntegrationLoggerInterface::class)->log('bpjs_antrean', 'info', null, []));

    Notification::assertNothingSent();
});

it('lists log integrasi paginated', function () {
    $this->asTenant(fn () => LogIntegrasi::factory()->count(3)->create());

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/integration-log')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data', 'meta' => ['current_page', 'per_page', 'total']])
        ->assertJsonCount(3, 'data');
});

it('filters log integrasi by status_resolusi', function () {
    $this->asTenant(function () {
        LogIntegrasi::factory()->create(['status_resolusi' => 'open']);
        LogIntegrasi::factory()->create(['status_resolusi' => 'resolved']);
    });

    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/integration-log?status_resolusi=resolved')
        ->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.status_resolusi', 'resolved');
});

it('shows a log integrasi detail', function () {
    $log = $this->asTenant(fn () => LogIntegrasi::factory()->create());

    $this->actingAs($this->admin)
        ->getJson("http://acme.localhost/api/v1/integration-log/{$log->id}")
        ->assertStatus(200)
        ->assertJsonPath('data.id', $log->id);
});

it('returns 404 when log integrasi is not found', function () {
    $this->actingAs($this->admin)
        ->getJson('http://acme.localhost/api/v1/integration-log/999999')
        ->assertStatus(404);
});

it('marks an open log integrasi as investigating', function () {
    $log = $this->asTenant(fn () => LogIntegrasi::factory()->create(['status_resolusi' => 'open']));

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/integration-log/{$log->id}/investigate")
        ->assertStatus(200)
        ->assertJsonPath('data.status_resolusi', 'investigating');
});

it('returns 422 when investigating a log that is not open', function () {
    $log = $this->asTenant(fn () => LogIntegrasi::factory()->create(['status_resolusi' => 'resolved']));

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/integration-log/{$log->id}/investigate")
        ->assertStatus(422);
});

it('resolves a log integrasi with catatan_resolusi', function () {
    $log = $this->asTenant(fn () => LogIntegrasi::factory()->create(['status_resolusi' => 'investigating']));

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/integration-log/{$log->id}/resolve", [
            'catatan_resolusi' => 'Sudah diperbaiki konfigurasi timeout.',
        ])
        ->assertStatus(200)
        ->assertJsonPath('data.status_resolusi', 'resolved')
        ->assertJsonPath('data.catatan_resolusi', 'Sudah diperbaiki konfigurasi timeout.')
        ->assertJsonPath('data.resolved_by', $this->admin->name);
});

it('returns 422 when resolve is missing catatan_resolusi', function () {
    $log = $this->asTenant(fn () => LogIntegrasi::factory()->create());

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/integration-log/{$log->id}/resolve", [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['catatan_resolusi']);
});

it('returns 422 when resolving a log that is already resolved', function () {
    $log = $this->asTenant(fn () => LogIntegrasi::factory()->create(['status_resolusi' => 'resolved']));

    $this->actingAs($this->admin)
        ->postJson("http://acme.localhost/api/v1/integration-log/{$log->id}/resolve", [
            'catatan_resolusi' => 'Coba resolve lagi',
        ])
        ->assertStatus(422);
});

it('returns 403 when the user lacks the manage permission', function () {
    $log = $this->asTenant(fn () => LogIntegrasi::factory()->create());
    $user = $this->asTenant(fn () => User::factory()->create());

    $this->actingAs($user)
        ->postJson("http://acme.localhost/api/v1/integration-log/{$log->id}/investigate")
        ->assertStatus(403);
});

it('returns 401 when unauthenticated', function () {
    $this->getJson('http://acme.localhost/api/v1/integration-log')->assertStatus(401);
});
