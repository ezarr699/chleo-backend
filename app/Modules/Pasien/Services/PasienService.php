<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Service
 * @file        PasienService.php
 * @path        app/Modules/Pasien/Services/PasienService.php
 * @description Business logic Pasien: CRUD, verifikasi (upload foto +
 *              lengkapi data, otomatis set status aktif), dan toggle
 *              status aktif/nonaktif (hanya untuk pasien yang sudah
 *              pernah diverifikasi).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\Pasien\Services;

use App\Models\Pasien;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use App\Modules\Pasien\Contracts\PasienRepositoryInterface;

final class PasienService
{
    public function __construct(
        private readonly PasienRepositoryInterface $pasienRepository,
    ) {}

    /** @return LengthAwarePaginator<int, Pasien> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->pasienRepository->paginate($perPage);
    }

    public function find(int $id): Pasien
    {
        $pasien = $this->pasienRepository->findById($id);

        abort_if($pasien === null, 404, 'Pasien tidak ditemukan.');

        return $pasien;
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Pasien
    {
        return $this->pasienRepository->create($data);
    }

    /** @param array<string, mixed> $data */
    public function update(int $id, array $data): Pasien
    {
        return $this->pasienRepository->update($this->find($id), $data);
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<int, array{asuransi_id: int, nomor_polis?: string, masa_berlaku?: string}>  $asuransiEntries
     */
    public function verify(int $id, array $data, UploadedFile $foto, array $asuransiEntries = []): Pasien
    {
        $data['foto_path'] = Storage::disk('public')->putFile('pasien', $foto);

        return $this->pasienRepository->verify($this->find($id), $data, $asuransiEntries);
    }

    public function setStatus(int $id, bool $aktif): Pasien
    {
        $pasien = $this->find($id);

        abort_if($pasien->verified_at === null, 422, 'Pasien belum diverifikasi.');

        return $this->pasienRepository->setStatus($pasien, $aktif);
    }

    public function delete(int $id): void
    {
        $this->pasienRepository->delete($this->find($id));
    }
}
