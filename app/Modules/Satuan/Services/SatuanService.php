<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Service
 * @file        SatuanService.php
 * @path        app/Modules/Satuan/Services/SatuanService.php
 * @description Business logic Satuan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Satuan\Services;

use App\Support\MasterData\AbstractMasterDataService;
use App\Modules\Satuan\Contracts\SatuanRepositoryInterface;

final class SatuanService extends AbstractMasterDataService
{
    public function __construct(SatuanRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
