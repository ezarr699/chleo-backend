<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Service
 * @file        PoliklinikService.php
 * @path        app/Modules/Poliklinik/Services/PoliklinikService.php
 * @description Business logic Poliklinik. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Poliklinik\Services;

use App\Support\MasterData\AbstractMasterDataService;
use App\Modules\Poliklinik\Contracts\PoliklinikRepositoryInterface;

final class PoliklinikService extends AbstractMasterDataService
{
    public function __construct(PoliklinikRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
