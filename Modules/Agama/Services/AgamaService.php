<?php
/**
 * ============================================================
 * @module      Agama
 * @layer       Service
 * @file        AgamaService.php
 * @path        Modules/Agama/Services/AgamaService.php
 * @description Business logic Agama. Logic CRUD generik diwarisi dari
 *              AbstractMasterDataService. Constructor type-hint langsung
 *              ke AgamaRepository (concrete, tanpa interface) — Laravel
 *              container resolve otomatis, tidak perlu binding di
 *              ServiceProvider (lihat Providers/AgamaServiceProvider.php).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Agama\Services;

use App\Support\MasterData\AbstractMasterDataService;
use Modules\Agama\Repositories\AgamaRepository;

final class AgamaService extends AbstractMasterDataService
{
    public function __construct(AgamaRepository $repository)
    {
        parent::__construct($repository);
    }
}
