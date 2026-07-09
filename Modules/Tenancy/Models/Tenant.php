<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Model
 * @file        Tenant.php
 * @path        Modules/Tenancy/Models/Tenant.php
 * @description Model Tenant (database central) — satu baris per
 *              organisasi/tenant. Mengimplementasikan TenantWithDatabase
 *              supaya stancl/tenancy bisa create/migrate/delete database
 *              tenant secara otomatis (database-per-tenant).
 *              PENTING: stancl's base Tenant model (lewat trait
 *              VirtualColumn) hanya menganggap `id` sebagai kolom asli —
 *              atribut lain disimpan ke kolom JSON `data`, bukan kolom
 *              tabel sungguhan, kecuali didaftarkan di getCustomColumns().
 *              `suspended_at` didaftarkan di sini supaya bisa di-query
 *              langsung lewat SQL (mis. whereNotNull di stats()).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://tenancyforlaravel.com/docs/v3/
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Tenancy\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, SoftDeletes;

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'suspended_at',
            'deleted_at',
        ];
    }

    protected function casts(): array
    {
        return [
            'suspended_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
