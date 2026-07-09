<?php
/**
 * ============================================================
 * @module      Core
 * @layer       Event (Global)
 * @file        UserCreatedOrUpdated.php
 * @path        app/Events/UserCreatedOrUpdated.php
 * @description Global Event untuk User (Modul Auth). Dipisah dari
 *              MasterDataCreatedOrUpdated (generik, id+nama) karena User
 *              bukan data master name-doang — modul subscriber (mis.
 *              ProfilNakes untuk tampilan user.email) butuh field email
 *              juga, bukan cuma nama. Dipicu dari
 *              Modules\Auth\Services\UserDirectoryService. Hanya
 *              membawa data primitif — dilarang membawa objek Model
 *              Eloquent utuh.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

final class UserCreatedOrUpdated
{
    use Dispatchable;

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
    ) {}
}
