<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Provider
 * @file        PekerjaanServiceProvider.php
 * @path        app/Modules/Pekerjaan/PekerjaanServiceProvider.php
 * @description Binding interface Repository ke implementasi untuk modul Pekerjaan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Pekerjaan;

use Illuminate\Support\ServiceProvider;
use App\Modules\Pekerjaan\Contracts\PekerjaanRepositoryInterface;
use App\Modules\Pekerjaan\Repositories\PekerjaanRepository;

final class PekerjaanServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PekerjaanRepositoryInterface::class, PekerjaanRepository::class);
    }
}
