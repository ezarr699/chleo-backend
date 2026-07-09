<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Notification
 * @file        IntegrationErrorDetected.php
 * @path        Modules/IntegrationLog/Notifications/IntegrationErrorDetected.php
 * @description Notifikasi ke admin (INT-01-3) saat LogIntegrasi baru
 *              dibuat dengan level 'error'. Channel database (in-app,
 *              tabel notifications) + mail (MAIL_MAILER=log di
 *              lingkungan dev, jadi cukup tercatat di log tanpa perlu
 *              SMTP asli).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://laravel.com/docs/13.x/notifications
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\IntegrationLog\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\IntegrationLog\Models\LogIntegrasi;

final class IntegrationErrorDetected extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly LogIntegrasi $log,
    ) {}

    /** @return array<int, string> */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Error Integrasi: {$this->log->integrasi}")
            ->line("Terjadi error pada integrasi {$this->log->integrasi}.")
            ->line($this->log->pesan_error ?? 'Tidak ada pesan detail.')
            ->action('Lihat Log Integrasi', url("/integration-log/{$this->log->id}"));
    }

    /** @return array<string, mixed> */
    public function toArray(object $notifiable): array
    {
        return [
            'log_integrasi_id' => $this->log->id,
            'integrasi' => $this->log->integrasi,
            'pesan_error' => $this->log->pesan_error,
        ];
    }
}
