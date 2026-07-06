<?php
/**
 * ============================================================
 * @module      Tenancy
 * @layer       Model
 * @file        Domain.php
 * @path        app/Modules/Tenancy/Models/Domain.php
 * @description Model Domain (database central) — pemetaan hostname
 *              (mis. acme.localhost) ke tenant_id.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://tenancyforlaravel.com/docs/v3/
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Tenancy\Models;

use Stancl\Tenancy\Database\Models\Domain as BaseDomain;

class Domain extends BaseDomain
{
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
