<?php
/**
 * ============================================================
 * @module      KategoriLayanan
 * @layer       Service
 * @file        KategoriLayananService.php
 * @path        Modules/KategoriLayanan/Services/KategoriLayananService.php
 * @description Business logic KategoriLayanan. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\KategoriLayanan\Services;

use App\Support\MasterData\AbstractMasterDataService;
use Modules\KategoriLayanan\Repositories\KategoriLayananRepository;

final class KategoriLayananService extends AbstractMasterDataService
{
    public function __construct(KategoriLayananRepository $repository)
    {
        parent::__construct($repository);
    }
}
