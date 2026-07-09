<?php
/**
 * ============================================================
 * @module      Profesi
 * @layer       Repository
 * @file        ProfesiRepository.php
 * @path        Modules/Profesi/Repositories/ProfesiRepository.php
 * @description Akses data Profesi. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Profesi\Repositories;

use Modules\Profesi\Models\Profesi;
use App\Support\MasterData\AbstractMasterDataRepository;

final class ProfesiRepository extends AbstractMasterDataRepository
{
    protected function modelClass(): string
    {
        return Profesi::class;
    }
}
