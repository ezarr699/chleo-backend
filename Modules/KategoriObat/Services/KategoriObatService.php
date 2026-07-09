<?php
/**
 * ============================================================
 * @module      KategoriObat
 * @layer       Service
 * @file        KategoriObatService.php
 * @path        Modules/KategoriObat/Services/KategoriObatService.php
 * @description Business logic KategoriObat. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\KategoriObat\Services;

use App\Support\MasterData\AbstractMasterDataService;
use Modules\KategoriObat\Repositories\KategoriObatRepository;

final class KategoriObatService extends AbstractMasterDataService
{
    public function __construct(KategoriObatRepository $repository)
    {
        parent::__construct($repository);
    }
}
