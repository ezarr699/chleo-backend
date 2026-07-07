<?php
/**
 * ============================================================
 * @module      StatusPerkawinan
 * @layer       Contract (Interface)
 * @file        StatusPerkawinanRepositoryInterface.php
 * @path        app/Modules/StatusPerkawinan/Contracts/StatusPerkawinanRepositoryInterface.php
 * @description Kontrak Repository StatusPerkawinan — murni untuk binding DI.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\StatusPerkawinan\Contracts;

use App\Support\MasterData\MasterDataRepositoryInterface;

interface StatusPerkawinanRepositoryInterface extends MasterDataRepositoryInterface {}
