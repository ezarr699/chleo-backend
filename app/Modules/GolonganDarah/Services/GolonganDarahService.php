<?php
/**
 * ============================================================
 * @module      GolonganDarah
 * @layer       Service
 * @file        GolonganDarahService.php
 * @path        app/Modules/GolonganDarah/Services/GolonganDarahService.php
 * @description Business logic GolonganDarah. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\GolonganDarah\Services;

use App\Support\MasterData\AbstractMasterDataService;
use App\Modules\GolonganDarah\Contracts\GolonganDarahRepositoryInterface;

final class GolonganDarahService extends AbstractMasterDataService
{
    public function __construct(GolonganDarahRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
