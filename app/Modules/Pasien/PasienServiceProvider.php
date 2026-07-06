<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Provider
 * @file        PasienServiceProvider.php
 * @path        app/Modules/Pasien/PasienServiceProvider.php
 * @description Bootstrap modul Pasien: binding interface ke implementasi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Pasien;

use Illuminate\Support\ServiceProvider;
use App\Modules\Pasien\Contracts\PasienRepositoryInterface;
use App\Modules\Pasien\Repositories\PasienRepository;

final class PasienServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PasienRepositoryInterface::class, PasienRepository::class);
    }
}
