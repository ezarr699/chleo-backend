<?php
/**
 * ============================================================
 * @module      StatusPerkawinan
 * @layer       Service
 * @file        StatusPerkawinanService.php
 * @path        Modules/StatusPerkawinan/Services/StatusPerkawinanService.php
 * @description Business logic StatusPerkawinan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\StatusPerkawinan\Services;

use App\Support\MasterData\AbstractMasterDataService;
use Modules\StatusPerkawinan\Repositories\StatusPerkawinanRepository;

final class StatusPerkawinanService extends AbstractMasterDataService
{
    public function __construct(StatusPerkawinanRepository $repository)
    {
        parent::__construct($repository);
    }
}
