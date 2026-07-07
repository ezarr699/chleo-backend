<?php
/**
 * ============================================================
 * @module      StatusPerkawinan
 * @layer       Service
 * @file        StatusPerkawinanService.php
 * @path        app/Modules/StatusPerkawinan/Services/StatusPerkawinanService.php
 * @description Business logic StatusPerkawinan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\StatusPerkawinan\Services;

use App\Support\MasterData\AbstractMasterDataService;
use App\Modules\StatusPerkawinan\Contracts\StatusPerkawinanRepositoryInterface;

final class StatusPerkawinanService extends AbstractMasterDataService
{
    public function __construct(StatusPerkawinanRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
