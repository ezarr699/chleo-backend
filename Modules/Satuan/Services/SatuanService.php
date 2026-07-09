<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Service
 * @file        SatuanService.php
 * @path        Modules/Satuan/Services/SatuanService.php
 * @description Business logic Satuan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Satuan\Services;

use App\Support\MasterData\AbstractMasterDataService;
use Modules\Satuan\Repositories\SatuanRepository;

final class SatuanService extends AbstractMasterDataService
{
    public function __construct(SatuanRepository $repository)
    {
        parent::__construct($repository);
    }
}
