<?php
/**
 * ============================================================
 * @module      Permission
 * @layer       Listener
 * @file        FlushPermissionCache.php
 * @path        Modules/Permission/Listeners/FlushPermissionCache.php
 * @description spatie/laravel-permission menyimpan role & permission yang
 *              sudah di-load di property in-memory milik PermissionRegistrar
 *              (container singleton). Karena tenancy menukar koneksi database
 *              di tengah proses PHP yang sama (tenancy()->initialize()/end()),
 *              singleton itu HARUS di-flush setiap kali tenancy berganti,
 *              kalau tidak role/permission tenant A bisa "nempel" ke
 *              request/test tenant B dalam proses PHP yang sama.
 *              Throwable ditangkap secara luas karena event tenancy bisa
 *              nested (mis. job CreateDatabase/MigrateDatabase saat
 *              membuat tenant baru juga initialize/end tenancy sendiri
 *              SEBELUM kode pemanggil sempat jalan), jadi titik di mana
 *              listener ini fire bisa berada di kondisi tabel `cache`
 *              belum ada atau koneksi "tenant" baru saja di-purge.
 *              forgetCachedPermissions() me-reset property in-memory
 *              SEBELUM mencoba hapus baris di cache store — bagian
 *              in-memory itu (yang mencegah kebocoran lintas tenant)
 *              tetap berhasil walau panggilan cache store di belakangnya
 *              gagal, jadi aman di-best-effort seperti ini.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://spatie.be/docs/laravel-permission
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Permission\Listeners;

use Spatie\Permission\PermissionRegistrar;
use Throwable;

final class FlushPermissionCache
{
    public function handle(): void
    {
        try {
            // forgetCachedPermissions() resets the in-memory $permissions
            // property FIRST, then tries to clear the cache-store entry —
            // the in-memory reset (what actually prevents cross-tenant
            // leakage) has already taken effect even if the cache-store
            // call below throws.
            app(PermissionRegistrar::class)->forgetCachedPermissions();
        } catch (Throwable) {
            // Best-effort cache-store cleanup only — see note above.
        }
    }
}
