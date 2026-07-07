<?php
/**
 * ============================================================
 * @module      KategoriObat
 * @layer       Service
 * @file        KategoriObatService.php
 * @path        app/Modules/KategoriObat/Services/KategoriObatService.php
 * @description Business logic KategoriObat. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\KategoriObat\Services;

use App\Support\MasterData\AbstractMasterDataService;
use App\Modules\KategoriObat\Contracts\KategoriObatRepositoryInterface;

final class KategoriObatService extends AbstractMasterDataService
{
    public function __construct(KategoriObatRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
