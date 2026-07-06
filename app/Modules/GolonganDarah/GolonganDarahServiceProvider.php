<?php
/**
 * ============================================================
 * @module      GolonganDarah
 * @layer       Provider
 * @file        GolonganDarahServiceProvider.php
 * @path        app/Modules/GolonganDarah/GolonganDarahServiceProvider.php
 * @description Bootstrap modul GolonganDarah: binding interface ke implementasi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\GolonganDarah;

use Illuminate\Support\ServiceProvider;
use App\Modules\GolonganDarah\Contracts\GolonganDarahRepositoryInterface;
use App\Modules\GolonganDarah\Repositories\GolonganDarahRepository;

final class GolonganDarahServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(GolonganDarahRepositoryInterface::class, GolonganDarahRepository::class);
    }
}
