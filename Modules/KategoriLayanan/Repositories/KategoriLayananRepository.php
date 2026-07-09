<?php
/**
 * ============================================================
 * @module      KategoriLayanan
 * @layer       Repository
 * @file        KategoriLayananRepository.php
 * @path        Modules/KategoriLayanan/Repositories/KategoriLayananRepository.php
 * @description Akses data KategoriLayanan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\KategoriLayanan\Repositories;

use Modules\KategoriLayanan\Models\KategoriLayanan;
use App\Support\MasterData\AbstractMasterDataRepository;

final class KategoriLayananRepository extends AbstractMasterDataRepository
{
    protected function modelClass(): string
    {
        return KategoriLayanan::class;
    }
}
