<?php
/**
 * ============================================================
 * @module      KategoriLayanan
 * @layer       Provider
 * @file        KategoriLayananServiceProvider.php
 * @path        app/Modules/KategoriLayanan/KategoriLayananServiceProvider.php
 * @description Binding interface Repository ke implementasi untuk modul KategoriLayanan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\KategoriLayanan;

use Illuminate\Support\ServiceProvider;
use App\Modules\KategoriLayanan\Contracts\KategoriLayananRepositoryInterface;
use App\Modules\KategoriLayanan\Repositories\KategoriLayananRepository;

final class KategoriLayananServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(KategoriLayananRepositoryInterface::class, KategoriLayananRepository::class);
    }
}
