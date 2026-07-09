<?php
/**
 * ============================================================
 * @module      Profesi
 * @layer       Service
 * @file        ProfesiService.php
 * @path        Modules/Profesi/Services/ProfesiService.php
 * @description Business logic Profesi. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Profesi\Services;

use App\Support\MasterData\AbstractMasterDataService;
use Modules\Profesi\Repositories\ProfesiRepository;

final class ProfesiService extends AbstractMasterDataService
{
    public function __construct(ProfesiRepository $repository)
    {
        parent::__construct($repository);
    }
}
