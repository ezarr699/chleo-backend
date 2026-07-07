<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Repository
 * @file        PekerjaanRepository.php
 * @path        app/Modules/Pekerjaan/Repositories/PekerjaanRepository.php
 * @description Akses data Pekerjaan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Pekerjaan\Repositories;

use App\Models\Pekerjaan;
use App\Support\MasterData\AbstractMasterDataRepository;
use App\Modules\Pekerjaan\Contracts\PekerjaanRepositoryInterface;

final class PekerjaanRepository extends AbstractMasterDataRepository implements PekerjaanRepositoryInterface
{
    protected function modelClass(): string
    {
        return Pekerjaan::class;
    }
}
