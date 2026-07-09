<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Service
 * @file        PendidikanTerakhirService.php
 * @path        Modules/PendidikanTerakhir/Services/PendidikanTerakhirService.php
 * @description Business logic PendidikanTerakhir. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\PendidikanTerakhir\Services;

use App\Support\MasterData\AbstractMasterDataService;
use Modules\PendidikanTerakhir\Repositories\PendidikanTerakhirRepository;

final class PendidikanTerakhirService extends AbstractMasterDataService
{
    public function __construct(PendidikanTerakhirRepository $repository)
    {
        parent::__construct($repository);
    }
}
