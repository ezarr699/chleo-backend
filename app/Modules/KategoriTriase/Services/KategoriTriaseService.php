<?php
/**
 * ============================================================
 * @module      KategoriTriase
 * @layer       Service
 * @file        KategoriTriaseService.php
 * @path        app/Modules/KategoriTriase/Services/KategoriTriaseService.php
 * @description Business logic KategoriTriase. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\KategoriTriase\Services;

use App\Support\MasterData\AbstractMasterDataService;
use App\Modules\KategoriTriase\Contracts\KategoriTriaseRepositoryInterface;

final class KategoriTriaseService extends AbstractMasterDataService
{
    public function __construct(KategoriTriaseRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
