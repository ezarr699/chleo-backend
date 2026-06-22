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

use App\Models\GolonganDarah;
use App\Support\MasterData\AbstractMasterDataRepository;
use Modules\GolonganDarah\Contracts\GolonganDarahRepositoryInterface;

final class GolonganDarahRepository extends AbstractMasterDataRepository implements GolonganDarahRepositoryInterface
{
    protected function modelClass(): string
    {
        return GolonganDarah::class;
    }
}
