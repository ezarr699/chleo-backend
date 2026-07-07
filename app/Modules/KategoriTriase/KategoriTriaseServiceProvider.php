<?php
/**
 * ============================================================
 * @module      KategoriTriase
 * @layer       Provider
 * @file        KategoriTriaseServiceProvider.php
 * @path        app/Modules/KategoriTriase/KategoriTriaseServiceProvider.php
 * @description Binding interface Repository ke implementasi untuk modul KategoriTriase.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\KategoriTriase;

use Illuminate\Support\ServiceProvider;
use App\Modules\KategoriTriase\Contracts\KategoriTriaseRepositoryInterface;
use App\Modules\KategoriTriase\Repositories\KategoriTriaseRepository;

final class KategoriTriaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(KategoriTriaseRepositoryInterface::class, KategoriTriaseRepository::class);
    }
}
