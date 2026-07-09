<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Repository
 * @file        PoliklinikRepository.php
 * @path        Modules/Poliklinik/Repositories/PoliklinikRepository.php
 * @description Akses data Poliklinik. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Poliklinik\Repositories;

use Modules\Poliklinik\Models\Poliklinik;
use App\Support\MasterData\AbstractMasterDataRepository;

final class PoliklinikRepository extends AbstractMasterDataRepository
{
    protected function modelClass(): string
    {
        return Poliklinik::class;
    }
}
