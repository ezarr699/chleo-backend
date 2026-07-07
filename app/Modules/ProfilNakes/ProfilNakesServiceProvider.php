<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Provider
 * @file        ProfilNakesServiceProvider.php
 * @path        app/Modules/ProfilNakes/ProfilNakesServiceProvider.php
 * @description Binding interface Repository ke implementasi untuk modul ProfilNakes.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\ProfilNakes;

use Illuminate\Support\ServiceProvider;
use App\Modules\ProfilNakes\Contracts\ProfilNakesRepositoryInterface;
use App\Modules\ProfilNakes\Repositories\ProfilNakesRepository;

final class ProfilNakesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProfilNakesRepositoryInterface::class, ProfilNakesRepository::class);
    }
}
