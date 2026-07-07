<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Provider
 * @file        PendidikanTerakhirServiceProvider.php
 * @path        app/Modules/PendidikanTerakhir/PendidikanTerakhirServiceProvider.php
 * @description Binding interface Repository ke implementasi untuk modul PendidikanTerakhir.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\PendidikanTerakhir;

use Illuminate\Support\ServiceProvider;
use App\Modules\PendidikanTerakhir\Contracts\PendidikanTerakhirRepositoryInterface;
use App\Modules\PendidikanTerakhir\Repositories\PendidikanTerakhirRepository;

final class PendidikanTerakhirServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PendidikanTerakhirRepositoryInterface::class, PendidikanTerakhirRepository::class);
    }
}
