<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Repository
 * @file        SatuanRepository.php
 * @path        Modules/Satuan/Repositories/SatuanRepository.php
 * @description Akses data Satuan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Satuan\Repositories;

use Modules\Satuan\Models\Satuan;
use App\Support\MasterData\AbstractMasterDataRepository;

final class SatuanRepository extends AbstractMasterDataRepository
{
    protected function modelClass(): string
    {
        return Satuan::class;
    }
}
