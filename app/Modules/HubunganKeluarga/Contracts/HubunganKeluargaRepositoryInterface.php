<?php
/**
 * ============================================================
 * @module      HubunganKeluarga
 * @layer       Contract (Interface)
 * @file        HubunganKeluargaRepositoryInterface.php
 * @path        app/Modules/HubunganKeluarga/Contracts/HubunganKeluargaRepositoryInterface.php
 * @description Kontrak Repository HubunganKeluarga — murni untuk binding DI.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\HubunganKeluarga\Contracts;

use App\Support\MasterData\MasterDataRepositoryInterface;

interface HubunganKeluargaRepositoryInterface extends MasterDataRepositoryInterface {}
