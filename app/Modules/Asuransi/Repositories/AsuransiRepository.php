<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Repository
 * @file        AsuransiRepository.php
 * @path        app/Modules/Asuransi/Repositories/AsuransiRepository.php
 * @description Akses data Asuransi. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Asuransi\Repositories;

use App\Models\Asuransi;
use App\Support\MasterData\AbstractMasterDataRepository;
use App\Modules\Asuransi\Contracts\AsuransiRepositoryInterface;

final class AsuransiRepository extends AbstractMasterDataRepository implements AsuransiRepositoryInterface
{
    protected function modelClass(): string
    {
        return Asuransi::class;
    }
}
