<?php
/**
 * ============================================================
 * @module      JenisKelamin
 * @layer       Service
 * @file        JenisKelaminService.php
 * @path        Modules/JenisKelamin/Services/JenisKelaminService.php
 * @description Business logic JenisKelamin. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\JenisKelamin\Services;

use App\Support\MasterData\AbstractMasterDataService;
use Modules\JenisKelamin\Contracts\JenisKelaminRepositoryInterface;

final class JenisKelaminService extends AbstractMasterDataService
{
    public function __construct(JenisKelaminRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
