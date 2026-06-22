<?php
/**
 * ============================================================
 * @module      MasterData
 * @layer       Support
 * @file        MasterDataValidationRules.php
 * @path        app/Support/MasterData/MasterDataValidationRules.php
 * @description Rule validasi generik (name wajib, unik per tabel) yang
 *              dipakai oleh Store/Update Request setiap modul data master.
 *              FormRequest tidak bisa menerima constructor argument lewat
 *              container saat resolve via route, jadi rules dipusatkan
 *              di static helper ini, bukan di abstract FormRequest.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Support\MasterData;

final class MasterDataValidationRules
{
    /** @return array<string, mixed> */
    public static function store(string $table): array
    {
        return [
            'name' => ['required', 'string', 'max:255', "unique:{$table},name"],
        ];
    }

    /** @return array<string, mixed> */
    public static function update(string $table, int $ignoreId): array
    {
        return [
            'name' => ['required', 'string', 'max:255', "unique:{$table},name,{$ignoreId}"],
        ];
    }
}
