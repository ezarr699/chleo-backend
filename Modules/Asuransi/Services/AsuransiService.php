<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Service
 * @file        AsuransiService.php
 * @path        Modules/Asuransi/Services/AsuransiService.php
 * @description Business logic Asuransi. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Asuransi\Services;

use App\Support\MasterData\AbstractMasterDataService;
use Modules\Asuransi\Contracts\AsuransiRepositoryInterface;

final class AsuransiService extends AbstractMasterDataService
{
    public function __construct(AsuransiRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
