<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Repository
 * @file        PendidikanTerakhirRepository.php
 * @path        app/Modules/PendidikanTerakhir/Repositories/PendidikanTerakhirRepository.php
 * @description Akses data PendidikanTerakhir. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\PendidikanTerakhir\Repositories;

use App\Models\PendidikanTerakhir;
use App\Support\MasterData\AbstractMasterDataRepository;
use App\Modules\PendidikanTerakhir\Contracts\PendidikanTerakhirRepositoryInterface;

final class PendidikanTerakhirRepository extends AbstractMasterDataRepository implements PendidikanTerakhirRepositoryInterface
{
    protected function modelClass(): string
    {
        return PendidikanTerakhir::class;
    }
}
