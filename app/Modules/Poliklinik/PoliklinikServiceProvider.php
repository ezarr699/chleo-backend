<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Provider
 * @file        PoliklinikServiceProvider.php
 * @path        app/Modules/Poliklinik/PoliklinikServiceProvider.php
 * @description Binding interface Repository ke implementasi untuk modul Poliklinik.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Poliklinik;

use Illuminate\Support\ServiceProvider;
use App\Modules\Poliklinik\Contracts\PoliklinikRepositoryInterface;
use App\Modules\Poliklinik\Repositories\PoliklinikRepository;

final class PoliklinikServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PoliklinikRepositoryInterface::class, PoliklinikRepository::class);
    }
}
