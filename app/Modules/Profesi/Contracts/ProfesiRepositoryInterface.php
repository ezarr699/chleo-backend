<?php
/**
 * ============================================================
 * @module      Profesi
 * @layer       Contract (Interface)
 * @file        ProfesiRepositoryInterface.php
 * @path        app/Modules/Profesi/Contracts/ProfesiRepositoryInterface.php
 * @description Kontrak Repository Profesi — murni untuk binding DI.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Profesi\Contracts;

use App\Support\MasterData\MasterDataRepositoryInterface;

interface ProfesiRepositoryInterface extends MasterDataRepositoryInterface {}
