<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Repository
 * @file        AsuransiRepository.php
 * @path        Modules/Asuransi/Repositories/AsuransiRepository.php
 * @description Akses data Asuransi. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Asuransi\Repositories;

use Modules\Asuransi\Models\Asuransi;
use App\Support\MasterData\AbstractMasterDataRepository;

final class AsuransiRepository extends AbstractMasterDataRepository
{
    protected function modelClass(): string
    {
        return Asuransi::class;
    }
}
