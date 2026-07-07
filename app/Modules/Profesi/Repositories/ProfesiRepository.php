<?php
/**
 * ============================================================
 * @module      Profesi
 * @layer       Repository
 * @file        ProfesiRepository.php
 * @path        app/Modules/Profesi/Repositories/ProfesiRepository.php
 * @description Akses data Profesi. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Profesi\Repositories;

use App\Models\Profesi;
use App\Support\MasterData\AbstractMasterDataRepository;
use App\Modules\Profesi\Contracts\ProfesiRepositoryInterface;

final class ProfesiRepository extends AbstractMasterDataRepository implements ProfesiRepositoryInterface
{
    protected function modelClass(): string
    {
        return Profesi::class;
    }
}
