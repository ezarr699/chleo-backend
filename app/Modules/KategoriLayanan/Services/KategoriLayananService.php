<?php
/**
 * ============================================================
 * @module      KategoriLayanan
 * @layer       Service
 * @file        KategoriLayananService.php
 * @path        app/Modules/KategoriLayanan/Services/KategoriLayananService.php
 * @description Business logic KategoriLayanan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\KategoriLayanan\Services;

use App\Support\MasterData\AbstractMasterDataService;
use App\Modules\KategoriLayanan\Contracts\KategoriLayananRepositoryInterface;

final class KategoriLayananService extends AbstractMasterDataService
{
    public function __construct(KategoriLayananRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
