<?php
/**
 * ============================================================
 * @module      HubunganKeluarga
 * @layer       Repository
 * @file        HubunganKeluargaRepository.php
 * @path        Modules/HubunganKeluarga/Repositories/HubunganKeluargaRepository.php
 * @description Akses data HubunganKeluarga. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\HubunganKeluarga\Repositories;

use Modules\HubunganKeluarga\Models\HubunganKeluarga;
use App\Support\MasterData\AbstractMasterDataRepository;

final class HubunganKeluargaRepository extends AbstractMasterDataRepository
{
    protected function modelClass(): string
    {
        return HubunganKeluarga::class;
    }
}
