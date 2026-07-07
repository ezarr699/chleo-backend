<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Service
 * @file        AgamaService.php
 * @path        app/Modules/Agama/Services/AgamaService.php
 * @description Business logic Agama. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Agama\Services;

use App\Support\MasterData\AbstractMasterDataService;
use App\Modules\Agama\Contracts\AgamaRepositoryInterface;

final class AgamaService extends AbstractMasterDataService
{
    public function __construct(AgamaRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
