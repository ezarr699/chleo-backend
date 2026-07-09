<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Model
 * @file        IntegrationLogUserCache.php
 * @path        Modules/IntegrationLog/Models/IntegrationLogUserCache.php
 * @description Replika lokal data User (id, nama) yang dibutuhkan
 *              IntegrationLog untuk menampilkan siapa yang resolve
 *              (resolved_by) sebuah LogIntegrasi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\IntegrationLog\Models;

use Illuminate\Database\Eloquent\Model;

final class IntegrationLogUserCache extends Model
{
    protected $table = 'integration_log_user_cache';

    protected $fillable = [
        'user_id',
        'nama',
        'synced_at',
    ];

    protected function casts(): array
    {
        return [
            'synced_at' => 'datetime',
        ];
    }
}
