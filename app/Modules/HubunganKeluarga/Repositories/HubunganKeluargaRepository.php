<?php
/**
 * ============================================================
 * @module      HubunganKeluarga
 * @layer       Repository
 * @file        HubunganKeluargaRepository.php
 * @path        app/Modules/HubunganKeluarga/Repositories/HubunganKeluargaRepository.php
 * @description Akses data HubunganKeluarga. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\HubunganKeluarga\Repositories;

use App\Models\HubunganKeluarga;
use App\Support\MasterData\AbstractMasterDataRepository;
use App\Modules\HubunganKeluarga\Contracts\HubunganKeluargaRepositoryInterface;

final class HubunganKeluargaRepository extends AbstractMasterDataRepository implements HubunganKeluargaRepositoryInterface
{
    protected function modelClass(): string
    {
        return HubunganKeluarga::class;
    }
}
