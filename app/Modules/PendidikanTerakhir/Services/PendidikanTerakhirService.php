<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Service
 * @file        PendidikanTerakhirService.php
 * @path        app/Modules/PendidikanTerakhir/Services/PendidikanTerakhirService.php
 * @description Business logic PendidikanTerakhir. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\PendidikanTerakhir\Services;

use App\Support\MasterData\AbstractMasterDataService;
use App\Modules\PendidikanTerakhir\Contracts\PendidikanTerakhirRepositoryInterface;

final class PendidikanTerakhirService extends AbstractMasterDataService
{
    public function __construct(PendidikanTerakhirRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
