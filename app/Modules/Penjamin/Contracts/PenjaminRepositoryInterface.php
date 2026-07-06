<?php
/**
 * ============================================================
 * @module      Penjamin
 * @layer       Contract (Interface)
 * @file        PenjaminRepositoryInterface.php
 * @path        app/Modules/Penjamin/Contracts/PenjaminRepositoryInterface.php
 * @description Kontrak Repository Penjamin — murni untuk binding DI.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Penjamin\Contracts;

use App\Support\MasterData\MasterDataRepositoryInterface;

interface PenjaminRepositoryInterface extends MasterDataRepositoryInterface {}
