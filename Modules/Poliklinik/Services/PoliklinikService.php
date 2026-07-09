<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Service
 * @file        PoliklinikService.php
 * @path        Modules/Poliklinik/Services/PoliklinikService.php
 * @description Business logic Poliklinik. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Poliklinik\Services;

use App\Support\MasterData\AbstractMasterDataService;
use Modules\Poliklinik\Repositories\PoliklinikRepository;

final class PoliklinikService extends AbstractMasterDataService
{
    public function __construct(PoliklinikRepository $repository)
    {
        parent::__construct($repository);
    }
}
