<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Repository
 * @file        AgamaRepository.php
 * @path        Modules/Agama/Repositories/AgamaRepository.php
 * @description Akses data Agama. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository (App\Support\MasterData —
 *              kode generik lintas modul yang tidak mengenal Model
 *              spesifik apa pun, jadi aman dipakai bersama tanpa
 *              melanggar Hukum Isolasi Total Eloquent).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Agama\Repositories;

use App\Support\MasterData\AbstractMasterDataRepository;
use Modules\Agama\Models\Agama;

final class AgamaRepository extends AbstractMasterDataRepository
{
    protected function modelClass(): string
    {
        return Agama::class;
    }
}
