<?php
/**
 * ============================================================
 * @module      KategoriTriase
 * @layer       Service
 * @file        KategoriTriaseService.php
 * @path        Modules/KategoriTriase/Services/KategoriTriaseService.php
 * @description Business logic KategoriTriase. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\KategoriTriase\Services;

use App\Support\MasterData\AbstractMasterDataService;
use Modules\KategoriTriase\Repositories\KategoriTriaseRepository;

final class KategoriTriaseService extends AbstractMasterDataService
{
    public function __construct(KategoriTriaseRepository $repository)
    {
        parent::__construct($repository);
    }
}
