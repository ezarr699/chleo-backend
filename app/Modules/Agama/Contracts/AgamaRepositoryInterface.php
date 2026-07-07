<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Contract (Interface)
 * @file        AgamaRepositoryInterface.php
 * @path        app/Modules/Agama/Contracts/AgamaRepositoryInterface.php
 * @description Kontrak Repository Agama — murni untuk binding DI.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Agama\Contracts;

use App\Support\MasterData\MasterDataRepositoryInterface;

interface AgamaRepositoryInterface extends MasterDataRepositoryInterface {}
