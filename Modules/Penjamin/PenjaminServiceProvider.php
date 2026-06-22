<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Provider
 * @file        PenjaminServiceProvider.php
 * @path        Modules/Penjamin/PenjaminServiceProvider.php
 * @description Bootstrap modul Penjamin: binding interface ke implementasi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Penjamin;

use Illuminate\Support\ServiceProvider;
use Modules\Penjamin\Contracts\PenjaminRepositoryInterface;
use Modules\Penjamin\Repositories\PenjaminRepository;

final class PenjaminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PenjaminRepositoryInterface::class, PenjaminRepository::class);
    }
}
