<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Repository
 * @file        SatuanRepository.php
 * @path        app/Modules/Satuan/Repositories/SatuanRepository.php
 * @description Akses data Satuan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Satuan\Repositories;

use App\Models\Satuan;
use App\Support\MasterData\AbstractMasterDataRepository;
use App\Modules\Satuan\Contracts\SatuanRepositoryInterface;

final class SatuanRepository extends AbstractMasterDataRepository implements SatuanRepositoryInterface
{
    protected function modelClass(): string
    {
        return Satuan::class;
    }
}
