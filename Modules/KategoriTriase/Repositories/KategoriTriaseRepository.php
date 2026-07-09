<?php
/**
 * ============================================================
 * @module      KategoriTriase
 * @layer       Repository
 * @file        KategoriTriaseRepository.php
 * @path        Modules/KategoriTriase/Repositories/KategoriTriaseRepository.php
 * @description Akses data KategoriTriase. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\KategoriTriase\Repositories;

use Modules\KategoriTriase\Models\KategoriTriase;
use App\Support\MasterData\AbstractMasterDataRepository;

final class KategoriTriaseRepository extends AbstractMasterDataRepository
{
    protected function modelClass(): string
    {
        return KategoriTriase::class;
    }
}
