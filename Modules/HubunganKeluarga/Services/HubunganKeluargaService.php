<?php
/**
 * ============================================================
 * @module      HubunganKeluarga
 * @layer       Service
 * @file        HubunganKeluargaService.php
 * @path        Modules/HubunganKeluarga/Services/HubunganKeluargaService.php
 * @description Business logic HubunganKeluarga. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\HubunganKeluarga\Services;

use App\Support\MasterData\AbstractMasterDataService;
use Modules\HubunganKeluarga\Repositories\HubunganKeluargaRepository;

final class HubunganKeluargaService extends AbstractMasterDataService
{
    public function __construct(HubunganKeluargaRepository $repository)
    {
        parent::__construct($repository);
    }
}
