<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Repository
 * @file        PoliklinikRepository.php
 * @path        app/Modules/Poliklinik/Repositories/PoliklinikRepository.php
 * @description Akses data Poliklinik. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Poliklinik\Repositories;

use App\Models\Poliklinik;
use App\Support\MasterData\AbstractMasterDataRepository;
use App\Modules\Poliklinik\Contracts\PoliklinikRepositoryInterface;

final class PoliklinikRepository extends AbstractMasterDataRepository implements PoliklinikRepositoryInterface
{
    protected function modelClass(): string
    {
        return Poliklinik::class;
    }
}
