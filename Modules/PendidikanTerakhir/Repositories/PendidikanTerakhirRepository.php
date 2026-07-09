<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Repository
 * @file        PendidikanTerakhirRepository.php
 * @path        Modules/PendidikanTerakhir/Repositories/PendidikanTerakhirRepository.php
 * @description Akses data PendidikanTerakhir. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\PendidikanTerakhir\Repositories;

use Modules\PendidikanTerakhir\Models\PendidikanTerakhir;
use App\Support\MasterData\AbstractMasterDataRepository;

final class PendidikanTerakhirRepository extends AbstractMasterDataRepository
{
    protected function modelClass(): string
    {
        return PendidikanTerakhir::class;
    }
}
