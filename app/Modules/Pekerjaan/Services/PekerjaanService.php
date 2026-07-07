<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Service
 * @file        PekerjaanService.php
 * @path        app/Modules/Pekerjaan/Services/PekerjaanService.php
 * @description Business logic Pekerjaan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Pekerjaan\Services;

use App\Support\MasterData\AbstractMasterDataService;
use App\Modules\Pekerjaan\Contracts\PekerjaanRepositoryInterface;

final class PekerjaanService extends AbstractMasterDataService
{
    public function __construct(PekerjaanRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
