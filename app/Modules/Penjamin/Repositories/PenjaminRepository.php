<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Repository
 * @file        PenjaminRepository.php
 * @path        app/Modules/Penjamin/Repositories/PenjaminRepository.php
 * @description Akses data Penjamin. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Penjamin\Repositories;

use App\Models\Penjamin;
use App\Support\MasterData\AbstractMasterDataRepository;
use App\Modules\Penjamin\Contracts\PenjaminRepositoryInterface;

final class PenjaminRepository extends AbstractMasterDataRepository implements PenjaminRepositoryInterface
{
    protected function modelClass(): string
    {
        return Penjamin::class;
    }
}
