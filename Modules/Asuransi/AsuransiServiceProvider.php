<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Provider
 * @file        AsuransiServiceProvider.php
 * @path        Modules/Asuransi/AsuransiServiceProvider.php
 * @description Bootstrap modul Asuransi: binding interface ke implementasi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Asuransi;

use Illuminate\Support\ServiceProvider;
use Modules\Asuransi\Contracts\AsuransiRepositoryInterface;
use Modules\Asuransi\Repositories\AsuransiRepository;

final class AsuransiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AsuransiRepositoryInterface::class, AsuransiRepository::class);
    }
}
