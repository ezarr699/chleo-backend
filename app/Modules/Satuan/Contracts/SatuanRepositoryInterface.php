<?php
/**
 * ============================================================
 * @module      Satuan
 * @layer       Contract (Interface)
 * @file        SatuanRepositoryInterface.php
 * @path        app/Modules/Satuan/Contracts/SatuanRepositoryInterface.php
 * @description Kontrak Repository Satuan — murni untuk binding DI.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Satuan\Contracts;

use App\Support\MasterData\MasterDataRepositoryInterface;

interface SatuanRepositoryInterface extends MasterDataRepositoryInterface {}
