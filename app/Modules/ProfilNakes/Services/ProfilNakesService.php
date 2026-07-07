<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Service
 * @file        ProfilNakesService.php
 * @path        app/Modules/ProfilNakes/Services/ProfilNakesService.php
 * @description Business logic ProfilNakes: CRUD dasar.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\ProfilNakes\Services;

use App\Models\ProfilNakes;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Modules\ProfilNakes\Contracts\ProfilNakesRepositoryInterface;

final class ProfilNakesService
{
    public function __construct(
        private readonly ProfilNakesRepositoryInterface $profilNakesRepository,
    ) {}

    /** @return LengthAwarePaginator<int, ProfilNakes> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->profilNakesRepository->paginate($perPage);
    }

    public function find(int $id): ProfilNakes
    {
        $profilNakes = $this->profilNakesRepository->findById($id);

        abort_if($profilNakes === null, 404, 'Profil nakes tidak ditemukan.');

        return $profilNakes;
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): ProfilNakes
    {
        return $this->profilNakesRepository->create($data);
    }

    /** @param array<string, mixed> $data */
    public function update(int $id, array $data): ProfilNakes
    {
        return $this->profilNakesRepository->update($this->find($id), $data);
    }

    public function delete(int $id): void
    {
        $this->profilNakesRepository->delete($this->find($id));
    }
}
