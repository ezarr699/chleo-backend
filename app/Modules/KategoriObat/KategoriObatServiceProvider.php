<?php
/**
 * ============================================================
 * @module      KategoriObat
 * @layer       Provider
 * @file        KategoriObatServiceProvider.php
 * @path        app/Modules/KategoriObat/KategoriObatServiceProvider.php
 * @description Binding interface Repository ke implementasi untuk modul KategoriObat.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\KategoriObat;

use Illuminate\Support\ServiceProvider;
use App\Modules\KategoriObat\Contracts\KategoriObatRepositoryInterface;
use App\Modules\KategoriObat\Repositories\KategoriObatRepository;

final class KategoriObatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(KategoriObatRepositoryInterface::class, KategoriObatRepository::class);
    }
}
