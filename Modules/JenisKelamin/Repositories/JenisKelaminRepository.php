<?php
/**
 * ============================================================
 * @module      JenisKelamin
 * @layer       Repository
 * @file        JenisKelaminRepository.php
 * @path        Modules/JenisKelamin/Repositories/JenisKelaminRepository.php
 * @description Akses data JenisKelamin. Logic CRUD generik diwarisi
 *              dari AbstractMasterDataRepository.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\JenisKelamin\Repositories;

use Modules\JenisKelamin\Models\JenisKelamin;
use App\Support\MasterData\AbstractMasterDataRepository;

final class JenisKelaminRepository extends AbstractMasterDataRepository
{
    protected function modelClass(): string
    {
        return JenisKelamin::class;
    }
}
