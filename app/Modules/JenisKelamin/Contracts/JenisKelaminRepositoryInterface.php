<?php
/**
 * ============================================================
 * @module      JenisKelamin
 * @layer       Contract (Interface)
 * @file        JenisKelaminRepositoryInterface.php
 * @path        app/Modules/JenisKelamin/Contracts/JenisKelaminRepositoryInterface.php
 * @description Kontrak Repository JenisKelamin — murni untuk binding DI.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\JenisKelamin\Contracts;

use App\Support\MasterData\MasterDataRepositoryInterface;

interface JenisKelaminRepositoryInterface extends MasterDataRepositoryInterface {}
