<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Model
 * @file        LogIntegrasi.php
 * @path        Modules/IntegrationLog/Models/LogIntegrasi.php
 * @description Model LogIntegrasi (INT-01) — satu baris per panggilan
 *              ke sistem eksternal (bridging). Dibuat lewat
 *              IntegrationLoggerService (implementasi
 *              Shared\Contracts\IntegrationLoggerInterface), bukan
 *              langsung oleh modul bridging manapun. resolved_by SENGAJA
 *              kolom polos tanpa relasi belongsTo ke User (modul lain —
 *              dilarang Hukum Isolasi Total Eloquent). Nama tampilannya
 *              diresolusi IntegrationLogService lewat
 *              Repositories/IntegrationLogUserCacheRepository.php.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

namespace Modules\IntegrationLog\Models;

use Database\Factories\LogIntegrasiFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'integrasi', 'referensi_tipe', 'referensi_id',
    'endpoint', 'metode', 'request_payload', 'response_payload', 'status_code',
    'level', 'pesan_error',
    'status_resolusi', 'catatan_resolusi', 'resolved_by', 'resolved_at',
])]
class LogIntegrasi extends Model
{
    /** @use HasFactory<LogIntegrasiFactory> */
    use HasFactory;

    protected $table = 'log_integrasi';

    protected function casts(): array
    {
        return [
            'request_payload' => 'array',
            'response_payload' => 'array',
            'resolved_at' => 'datetime',
        ];
    }

    /**
     * Laravel's default factory-name resolver assumes models live under the
     * App\ namespace and only swaps that prefix for Database\Factories\ --
     * it can't find LogIntegrasiFactory once the model moves to
     * Modules\IntegrationLog\Models, so the mapping has to be explicit here
     * instead of relying on convention.
     */
    protected static function newFactory(): LogIntegrasiFactory
    {
        return LogIntegrasiFactory::new();
    }
}
