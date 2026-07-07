<?php
/**
 * ============================================================
 * @module      KategoriLayanan
 * @layer       Repository
 * @file        KategoriLayananRepository.php
 * @path        app/Modules/KategoriLayanan/Repositories/KategoriLayananRepository.php
 * @description Akses data KategoriLayanan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\KategoriLayanan\Repositories;

use App\Models\KategoriLayanan;
use App\Support\MasterData\AbstractMasterDataRepository;
use App\Modules\KategoriLayanan\Contracts\KategoriLayananRepositoryInterface;

final class KategoriLayananRepository extends AbstractMasterDataRepository implements KategoriLayananRepositoryInterface
{
    protected function modelClass(): string
    {
        return KategoriLayanan::class;
    }
}
