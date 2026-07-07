<?php
/**
 * ============================================================
 * @module      KategoriTriase
 * @layer       Repository
 * @file        KategoriTriaseRepository.php
 * @path        app/Modules/KategoriTriase/Repositories/KategoriTriaseRepository.php
 * @description Akses data KategoriTriase. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\KategoriTriase\Repositories;

use App\Models\KategoriTriase;
use App\Support\MasterData\AbstractMasterDataRepository;
use App\Modules\KategoriTriase\Contracts\KategoriTriaseRepositoryInterface;

final class KategoriTriaseRepository extends AbstractMasterDataRepository implements KategoriTriaseRepositoryInterface
{
    protected function modelClass(): string
    {
        return KategoriTriase::class;
    }
}
