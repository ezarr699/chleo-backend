<?php
/**
 * ============================================================
 * @module      GolonganDarah
 * @layer       Repository
 * @file        GolonganDarahRepository.php
 * @path        Modules/GolonganDarah/Repositories/GolonganDarahRepository.php
 * @description Akses data GolonganDarah. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\GolonganDarah\Repositories;

use Modules\GolonganDarah\Models\GolonganDarah;
use App\Support\MasterData\AbstractMasterDataRepository;

final class GolonganDarahRepository extends AbstractMasterDataRepository
{
    protected function modelClass(): string
    {
        return GolonganDarah::class;
    }
}
