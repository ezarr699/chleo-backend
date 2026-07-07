<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Provider
 * @file        SatuanServiceProvider.php
 * @path        app/Modules/Satuan/SatuanServiceProvider.php
 * @description Binding interface Repository ke implementasi untuk modul Satuan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Satuan;

use Illuminate\Support\ServiceProvider;
use App\Modules\Satuan\Contracts\SatuanRepositoryInterface;
use App\Modules\Satuan\Repositories\SatuanRepository;

final class SatuanServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SatuanRepositoryInterface::class, SatuanRepository::class);
    }
}
