<?php
/**
 * ============================================================
 * @module      StatusPerkawinan
 * @layer       Repository
 * @file        StatusPerkawinanRepository.php
 * @path        app/Modules/StatusPerkawinan/Repositories/StatusPerkawinanRepository.php
 * @description Akses data StatusPerkawinan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\StatusPerkawinan\Repositories;

use App\Models\StatusPerkawinan;
use App\Support\MasterData\AbstractMasterDataRepository;
use App\Modules\StatusPerkawinan\Contracts\StatusPerkawinanRepositoryInterface;

final class StatusPerkawinanRepository extends AbstractMasterDataRepository implements StatusPerkawinanRepositoryInterface
{
    protected function modelClass(): string
    {
        return StatusPerkawinan::class;
    }
}
