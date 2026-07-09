<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Repository
 * @file        PenjaminRepository.php
 * @path        Modules/Penjamin/Repositories/PenjaminRepository.php
 * @description Akses data Penjamin. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Penjamin\Repositories;

use Modules\Penjamin\Models\Penjamin;
use App\Support\MasterData\AbstractMasterDataRepository;

final class PenjaminRepository extends AbstractMasterDataRepository
{
    protected function modelClass(): string
    {
        return Penjamin::class;
    }
}
