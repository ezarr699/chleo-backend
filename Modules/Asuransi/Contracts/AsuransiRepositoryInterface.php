<?php
/**
 * ============================================================
 * @module      Asuransi
 * @layer       Contract (Interface)
 * @file        AsuransiRepositoryInterface.php
 * @path        Modules/Asuransi/Contracts/AsuransiRepositoryInterface.php
 * @description Kontrak Repository Asuransi — murni untuk binding DI.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Asuransi\Contracts;

use App\Support\MasterData\MasterDataRepositoryInterface;

interface AsuransiRepositoryInterface extends MasterDataRepositoryInterface {}
