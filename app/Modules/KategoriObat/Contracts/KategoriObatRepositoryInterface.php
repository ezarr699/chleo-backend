<?php
/**
 * ============================================================
 * @module      KategoriObat
 * @layer       Contract (Interface)
 * @file        KategoriObatRepositoryInterface.php
 * @path        app/Modules/KategoriObat/Contracts/KategoriObatRepositoryInterface.php
 * @description Kontrak Repository KategoriObat — murni untuk binding DI.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\KategoriObat\Contracts;

use App\Support\MasterData\MasterDataRepositoryInterface;

interface KategoriObatRepositoryInterface extends MasterDataRepositoryInterface {}
