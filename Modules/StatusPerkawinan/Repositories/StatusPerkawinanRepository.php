<?php
/**
 * ============================================================
 * @module      StatusPerkawinan
 * @layer       Repository
 * @file        StatusPerkawinanRepository.php
 * @path        Modules/StatusPerkawinan/Repositories/StatusPerkawinanRepository.php
 * @description Akses data StatusPerkawinan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\StatusPerkawinan\Repositories;

use Modules\StatusPerkawinan\Models\StatusPerkawinan;
use App\Support\MasterData\AbstractMasterDataRepository;

final class StatusPerkawinanRepository extends AbstractMasterDataRepository
{
    protected function modelClass(): string
    {
        return StatusPerkawinan::class;
    }
}
