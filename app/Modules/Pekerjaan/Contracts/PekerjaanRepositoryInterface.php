<?php
/**
 * ============================================================
 * @module      Pekerjaan
 * @layer       Contract (Interface)
 * @file        PekerjaanRepositoryInterface.php
 * @path        app/Modules/Pekerjaan/Contracts/PekerjaanRepositoryInterface.php
 * @description Kontrak Repository Pekerjaan — murni untuk binding DI.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Pekerjaan\Contracts;

use App\Support\MasterData\MasterDataRepositoryInterface;

interface PekerjaanRepositoryInterface extends MasterDataRepositoryInterface {}
