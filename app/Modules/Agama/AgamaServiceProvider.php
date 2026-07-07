<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Provider
 * @file        AgamaServiceProvider.php
 * @path        app/Modules/Agama/AgamaServiceProvider.php
 * @description Binding interface Repository ke implementasi untuk modul Agama.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Agama;

use Illuminate\Support\ServiceProvider;
use App\Modules\Agama\Contracts\AgamaRepositoryInterface;
use App\Modules\Agama\Repositories\AgamaRepository;

final class AgamaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AgamaRepositoryInterface::class, AgamaRepository::class);
    }
}
