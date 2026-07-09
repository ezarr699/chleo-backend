<?php
/**
 * ============================================================
 * @module      Billing
 * @layer       Provider
 * @file        BillingServiceProvider.php
 * @path        Modules/Billing/Providers/BillingServiceProvider.php
 * @description Bootstrap Modul Billing. parent::boot() (lihat
 *              Modules/BaseServiceProvider.php) mengotomasi load
 *              Routes/tenant.php (prefix v1 + middleware tenancy) dan
 *              Database/Migrations/ central kalau ada. Provider ini
 *              hanya menambahkan satu hal yang spesifik milik Billing:
 *              mendaftarkan SyncPasienToBilling sebagai listener Global
 *              Event PasienCreatedOrUpdated, supaya Modul Pasien (Publisher)
 *              tidak perlu tahu apa-apa soal keberadaan Modul Billing
 *              (Subscriber) — arah ketergantungan cuma satu jalan.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Billing\Providers;

use App\Events\PasienCreatedOrUpdated;
use Illuminate\Support\Facades\Event;
use Modules\BaseServiceProvider;
use Modules\Billing\Listeners\SyncPasienToBilling;

final class BillingServiceProvider extends BaseServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        parent::boot();

        Event::listen(PasienCreatedOrUpdated::class, SyncPasienToBilling::class);
    }
}
