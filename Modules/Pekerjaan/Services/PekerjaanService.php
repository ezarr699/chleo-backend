<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Service
 * @file        PekerjaanService.php
 * @path        Modules/Pekerjaan/Services/PekerjaanService.php
 * @description Business logic Pekerjaan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pekerjaan\Services;

use App\Support\MasterData\AbstractMasterDataService;
use Modules\Pekerjaan\Repositories\PekerjaanRepository;

final class PekerjaanService extends AbstractMasterDataService
{
    public function __construct(PekerjaanRepository $repository)
    {
        parent::__construct($repository);
    }
}
