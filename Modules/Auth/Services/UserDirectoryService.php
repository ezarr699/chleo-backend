<?php
/**
 * ============================================================
 * @module      Auth
 * @layer       Service
 * @file        UserDirectoryService.php
 * @path        Modules/Auth/Services/UserDirectoryService.php
 * @description Implementasi Shared\Contracts\UserProvisioningInterface dan
 *              Shared\Contracts\AdminNotifierInterface — dua kontrak
 *              sempit yang membungkus akses ke Model User supaya modul
 *              lain (Tenancy, IntegrationLog) tidak perlu mengimpornya
 *              langsung. create() memicu Global Event
 *              App\Events\UserCreatedOrUpdated supaya modul lain yang
 *              cuma butuh MENAMPILKAN nama/email user (mis. ProfilNakes,
 *              Registrasi) bisa menyinkronkan cache lokalnya sendiri.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Auth\Services;

use App\Events\UserCreatedOrUpdated;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Modules\Auth\Models\User;
use Modules\Shared\Contracts\AdminNotifierInterface;
use Modules\Shared\Contracts\UserProvisioningInterface;

final class UserDirectoryService implements UserProvisioningInterface, AdminNotifierInterface
{
    public function ensureAdminExists(string $name, string $email, string $password): void
    {
        $user = User::where('email', $email)->first();

        if ($user === null) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            UserCreatedOrUpdated::dispatch($user->id, $user->name, $user->email);
        }

        if (! $user->hasRole('admin')) {
            $user->assignRole('admin');
        }
    }

    public function notifyAdmins(Notification $notification): void
    {
        $admins = User::role('admin')->get();

        if ($admins->isNotEmpty()) {
            NotificationFacade::send($admins, $notification);
        }
    }
}
