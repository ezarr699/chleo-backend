<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Listener
 * @file        SyncUserToIntegrationLog.php
 * @path        Modules/IntegrationLog/Listeners/SyncUserToIntegrationLog.php
 * @description Penguping Global Event App\Events\UserCreatedOrUpdated.
 *              Tidak pernah menyentuh Model User — hanya membaca field
 *              primitif dari payload event.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\IntegrationLog\Listeners;

use App\Events\UserCreatedOrUpdated;
use Modules\IntegrationLog\Repositories\IntegrationLogUserCacheRepository;

final class SyncUserToIntegrationLog
{
    public function __construct(
        private readonly IntegrationLogUserCacheRepository $userCacheRepository,
    ) {}

    public function handle(UserCreatedOrUpdated $event): void
    {
        $this->userCacheRepository->upsert($event->id, $event->name);
    }
}
