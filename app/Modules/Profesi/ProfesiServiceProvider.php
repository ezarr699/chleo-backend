<?php
/**
 * ============================================================
 * @module      Profesi
 * @layer       Provider
 * @file        ProfesiServiceProvider.php
 * @path        app/Modules/Profesi/ProfesiServiceProvider.php
 * @description Binding interface Repository ke implementasi untuk modul Profesi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Profesi;

use Illuminate\Support\ServiceProvider;
use App\Modules\Profesi\Contracts\ProfesiRepositoryInterface;
use App\Modules\Profesi\Repositories\ProfesiRepository;

final class ProfesiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProfesiRepositoryInterface::class, ProfesiRepository::class);
    }
}
