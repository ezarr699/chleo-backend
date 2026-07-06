<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Provider
 * @file        AsuransiServiceProvider.php
 * @path        app/Modules/Asuransi/AsuransiServiceProvider.php
 * @description Bootstrap modul Asuransi: binding interface ke implementasi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Asuransi;

use Illuminate\Support\ServiceProvider;
use App\Modules\Asuransi\Contracts\AsuransiRepositoryInterface;
use App\Modules\Asuransi\Repositories\AsuransiRepository;

final class AsuransiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AsuransiRepositoryInterface::class, AsuransiRepository::class);
    }
}
