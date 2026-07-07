<?php
/**
 * ============================================================
 * @module      KategoriObat
 * @layer       Repository
 * @file        KategoriObatRepository.php
 * @path        app/Modules/KategoriObat/Repositories/KategoriObatRepository.php
 * @description Akses data KategoriObat. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\KategoriObat\Repositories;

use App\Models\KategoriObat;
use App\Support\MasterData\AbstractMasterDataRepository;
use App\Modules\KategoriObat\Contracts\KategoriObatRepositoryInterface;

final class KategoriObatRepository extends AbstractMasterDataRepository implements KategoriObatRepositoryInterface
{
    protected function modelClass(): string
    {
        return KategoriObat::class;
    }
}
