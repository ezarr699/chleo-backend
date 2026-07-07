<?php
/**
 * ============================================================
 * @module      KategoriLayanan
 * @layer       Contract (Interface)
 * @file        KategoriLayananRepositoryInterface.php
 * @path        app/Modules/KategoriLayanan/Contracts/KategoriLayananRepositoryInterface.php
 * @description Kontrak Repository KategoriLayanan — murni untuk binding DI.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\KategoriLayanan\Contracts;

use App\Support\MasterData\MasterDataRepositoryInterface;

interface KategoriLayananRepositoryInterface extends MasterDataRepositoryInterface {}
