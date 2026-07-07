<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Repository
 * @file        AgamaRepository.php
 * @path        app/Modules/Agama/Repositories/AgamaRepository.php
 * @description Akses data Agama. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Agama\Repositories;

use App\Models\Agama;
use App\Support\MasterData\AbstractMasterDataRepository;
use App\Modules\Agama\Contracts\AgamaRepositoryInterface;

final class AgamaRepository extends AbstractMasterDataRepository implements AgamaRepositoryInterface
{
    protected function modelClass(): string
    {
        return Agama::class;
    }
}
