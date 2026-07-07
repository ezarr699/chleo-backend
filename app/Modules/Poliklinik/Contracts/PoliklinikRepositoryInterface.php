<?php
/**
 * ============================================================
 * @module      Poliklinik
 * @layer       Contract (Interface)
 * @file        PoliklinikRepositoryInterface.php
 * @path        app/Modules/Poliklinik/Contracts/PoliklinikRepositoryInterface.php
 * @description Kontrak Repository Poliklinik — murni untuk binding DI.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Poliklinik\Contracts;

use App\Support\MasterData\MasterDataRepositoryInterface;

interface PoliklinikRepositoryInterface extends MasterDataRepositoryInterface {}
