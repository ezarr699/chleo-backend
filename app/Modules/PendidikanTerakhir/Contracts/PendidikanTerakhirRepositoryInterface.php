<?php
/**
 * ============================================================
 * @module      PendidikanTerakhir
 * @layer       Contract (Interface)
 * @file        PendidikanTerakhirRepositoryInterface.php
 * @path        app/Modules/PendidikanTerakhir/Contracts/PendidikanTerakhirRepositoryInterface.php
 * @description Kontrak Repository PendidikanTerakhir — murni untuk binding DI.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\PendidikanTerakhir\Contracts;

use App\Support\MasterData\MasterDataRepositoryInterface;

interface PendidikanTerakhirRepositoryInterface extends MasterDataRepositoryInterface {}
