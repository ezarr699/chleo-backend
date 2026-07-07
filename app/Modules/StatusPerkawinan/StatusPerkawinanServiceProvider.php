<?php
/**
 * ============================================================
 * @module      StatusPerkawinan
 * @layer       Provider
 * @file        StatusPerkawinanServiceProvider.php
 * @path        app/Modules/StatusPerkawinan/StatusPerkawinanServiceProvider.php
 * @description Binding interface Repository ke implementasi untuk modul StatusPerkawinan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\StatusPerkawinan;

use Illuminate\Support\ServiceProvider;
use App\Modules\StatusPerkawinan\Contracts\StatusPerkawinanRepositoryInterface;
use App\Modules\StatusPerkawinan\Repositories\StatusPerkawinanRepository;

final class StatusPerkawinanServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(StatusPerkawinanRepositoryInterface::class, StatusPerkawinanRepository::class);
    }
}
