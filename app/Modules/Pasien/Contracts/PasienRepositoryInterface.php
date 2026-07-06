<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Contract (Interface)
 * @file        PasienRepositoryInterface.php
 * @path        app/Modules/Pasien/Contracts/PasienRepositoryInterface.php
 * @description Kontrak untuk implementasi Repository Pasien.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Pasien\Contracts;

use App\Models\Pasien;
use Illuminate\Pagination\LengthAwarePaginator;

interface PasienRepositoryInterface
{
    /** @return LengthAwarePaginator<int, Pasien> */
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): ?Pasien;

    /** @param array<string, mixed> $data */
    public function create(array $data): Pasien;

    /** @param array<string, mixed> $data */
    public function update(Pasien $pasien, array $data): Pasien;

    /**
     * @param  array<string, mixed>  $data
     * @param  array<int, array{asuransi_id: int, nomor_polis?: string, masa_berlaku?: string}>  $asuransiEntries
     */
    public function verify(Pasien $pasien, array $data, array $asuransiEntries = []): Pasien;

    public function setStatus(Pasien $pasien, bool $aktif): Pasien;

    public function delete(Pasien $pasien): void;
}
