<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Provider
 * @file        IntegrationLogServiceProvider.php
 * @path        Modules/IntegrationLog/Providers/IntegrationLogServiceProvider.php
 * @description Bootstrap modul IntegrationLog. Binding
 *              Shared\Contracts\IntegrationLoggerInterface (dipakai modul
 *              bridging lain) ke implementasinya di modul ini — tidak
 *              ada lagi binding IntegrationLogRepositoryInterface
 *              (Contracts/ dihapus, Service type-hint langsung ke
 *              Repository konkret). Mendaftarkan SyncUserToIntegrationLog
 *              sebagai listener Global Event UserCreatedOrUpdated —
 *              Modul Auth tidak perlu tahu apa-apa soal keberadaan modul
 *              ini. parent::boot() (Modules/BaseServiceProvider.php)
 *              mengotomasi load Routes/tenant.php + Database/Migrations/.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\IntegrationLog\Providers;

use App\Events\UserCreatedOrUpdated;
use Illuminate\Support\Facades\Event;
use Modules\BaseServiceProvider;
use Modules\IntegrationLog\Listeners\SyncUserToIntegrationLog;
use Modules\IntegrationLog\Services\IntegrationLoggerService;
use Modules\Shared\Contracts\IntegrationLoggerInterface;

final class IntegrationLogServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IntegrationLoggerInterface::class, IntegrationLoggerService::class);
    }

    public function boot(): void
    {
        parent::boot();

        Event::listen(UserCreatedOrUpdated::class, SyncUserToIntegrationLog::class);
    }
}
