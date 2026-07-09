<?php
/**
 * ============================================================
 * @module      Wilayah
 * @layer       Provider
 * @file        WilayahServiceProvider.php
 * @path        Modules/Wilayah/Providers/WilayahServiceProvider.php
 * @description Bootstrap modul Wilayah. Binding
 *              Shared\Contracts\WilayahLookupInterface ke
 *              WilayahLookupService supaya modul lain bisa resolve nama
 *              wilayah tanpa mengimpor Model milik modul ini. Tidak ada
 *              Database/Migrations/ di sini karena tabel indonesia_* dibuat
 *              oleh migration bawaan package laravolt/indonesia sendiri
 *              (auto-discovered lewat package service provider), bukan
 *              migration milik aplikasi ini.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Wilayah\Providers;

use Modules\BaseServiceProvider;
use Modules\Shared\Contracts\WilayahLookupInterface;
use Modules\Wilayah\Services\WilayahLookupService;

final class WilayahServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->app->bind(WilayahLookupInterface::class, WilayahLookupService::class);
    }
}
