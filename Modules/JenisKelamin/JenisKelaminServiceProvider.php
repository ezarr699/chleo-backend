<?php
/**
 * ============================================================
 * @module      JenisKelamin
 * @layer       Provider
 * @file        JenisKelaminServiceProvider.php
 * @path        Modules/JenisKelamin/JenisKelaminServiceProvider.php
 * @description Bootstrap modul JenisKelamin: binding interface ke implementasi.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\JenisKelamin;

use Illuminate\Support\ServiceProvider;
use Modules\JenisKelamin\Contracts\JenisKelaminRepositoryInterface;
use Modules\JenisKelamin\Repositories\JenisKelaminRepository;

final class JenisKelaminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(JenisKelaminRepositoryInterface::class, JenisKelaminRepository::class);
    }
}
