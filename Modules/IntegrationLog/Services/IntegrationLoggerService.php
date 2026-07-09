<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Service
 * @file        IntegrationLoggerService.php
 * @path        Modules/IntegrationLog/Services/IntegrationLoggerService.php
 * @description Implementasi Shared\Contracts\IntegrationLoggerInterface —
 *              jalur tulis yang dipakai modul bridging lain (JKN-01-2,
 *              REG-01-2-1 SISRUTE, API-02 SatuSehat, PNJ-01-1 Analyzer)
 *              untuk mencatat panggilan ke sistem eksternal. Saat level
 *              'error', memicu notifikasi ke semua user ber-role admin
 *              (INT-01-3) lewat IntegrationErrorDetected — dikirim lewat
 *              Shared\Contracts\AdminNotifierInterface, BUKAN query
 *              Model User langsung (Hukum Isolasi Total Eloquent; Model
 *              User milik Modul Auth).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\IntegrationLog\Services;

use Modules\IntegrationLog\Notifications\IntegrationErrorDetected;
use Modules\IntegrationLog\Repositories\IntegrationLogRepository;
use Modules\Shared\Contracts\AdminNotifierInterface;
use Modules\Shared\Contracts\IntegrationLoggerInterface;

final class IntegrationLoggerService implements IntegrationLoggerInterface
{
    public function __construct(
        private readonly IntegrationLogRepository $integrationLogRepository,
        private readonly AdminNotifierInterface $adminNotifier,
    ) {}

    /** @param array<string, mixed> $context */
    public function log(string $integrasi, string $level, ?string $pesanError = null, array $context = []): void
    {
        $log = $this->integrationLogRepository->create([
            ...$context,
            'integrasi' => $integrasi,
            'level' => $level,
            'pesan_error' => $pesanError,
        ]);

        if ($level === 'error') {
            $this->adminNotifier->notifyAdmins(new IntegrationErrorDetected($log));
        }
    }
}
