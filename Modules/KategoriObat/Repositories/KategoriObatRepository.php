<?php
/**
 * ============================================================
 * @module      KategoriObat
 * @layer       Repository
 * @file        KategoriObatRepository.php
 * @path        Modules/KategoriObat/Repositories/KategoriObatRepository.php
 * @description Akses data KategoriObat. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\KategoriObat\Repositories;

use Modules\KategoriObat\Models\KategoriObat;
use App\Support\MasterData\AbstractMasterDataRepository;

final class KategoriObatRepository extends AbstractMasterDataRepository
{
    protected function modelClass(): string
    {
        return KategoriObat::class;
    }
}
