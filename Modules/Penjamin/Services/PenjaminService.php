<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Service
 * @file        PenjaminService.php
 * @path        Modules/Penjamin/Services/PenjaminService.php
 * @description Business logic Penjamin. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Penjamin\Services;

use App\Support\MasterData\AbstractMasterDataService;
use Modules\Penjamin\Contracts\PenjaminRepositoryInterface;

final class PenjaminService extends AbstractMasterDataService
{
    public function __construct(PenjaminRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
