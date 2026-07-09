<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Repository
 * @file        PekerjaanRepository.php
 * @path        Modules/Pekerjaan/Repositories/PekerjaanRepository.php
 * @description Akses data Pekerjaan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pekerjaan\Repositories;

use Modules\Pekerjaan\Models\Pekerjaan;
use App\Support\MasterData\AbstractMasterDataRepository;

final class PekerjaanRepository extends AbstractMasterDataRepository
{
    protected function modelClass(): string
    {
        return Pekerjaan::class;
    }
}
