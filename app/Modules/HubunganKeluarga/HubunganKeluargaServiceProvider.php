<?php
/**
 * ============================================================
 * @module      HubunganKeluarga
 * @layer       Provider
 * @file        HubunganKeluargaServiceProvider.php
 * @path        app/Modules/HubunganKeluarga/HubunganKeluargaServiceProvider.php
 * @description Binding interface Repository ke implementasi untuk modul HubunganKeluarga.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\HubunganKeluarga;

use Illuminate\Support\ServiceProvider;
use App\Modules\HubunganKeluarga\Contracts\HubunganKeluargaRepositoryInterface;
use App\Modules\HubunganKeluarga\Repositories\HubunganKeluargaRepository;

final class HubunganKeluargaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(HubunganKeluargaRepositoryInterface::class, HubunganKeluargaRepository::class);
    }
}
