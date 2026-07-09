<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Service
 * @file        ProfilNakesService.php
 * @path        Modules/ProfilNakes/Services/ProfilNakesService.php
 * @description Business logic ProfilNakes: CRUD dasar + resolusi nama
 *              tampilan lintas modul (user, profesi, poliklinik) lewat
 *              cache lokal secara batch supaya index() tidak N+1 query —
 *              pola yang sama dengan Modules/Pasien/Services/PasienService.php.
 *              create()/update() memicu ProfilNakesCreatedOrUpdated
 *              (nama = HASIL RESOLUSI dari user_nama, karena ProfilNakes
 *              sendiri tidak punya kolom "name") supaya modul lain (mis.
 *              Registrasi, untuk tampilan profil_nakes di Kunjungan) bisa
 *              menyinkronkan cache lokalnya sendiri.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\ProfilNakes\Services;

use App\Events\ProfilNakesCreatedOrUpdated;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\ProfilNakes\Models\ProfilNakes;
use Modules\ProfilNakes\Repositories\ProfilNakesMasterDataCacheRepository;
use Modules\ProfilNakes\Repositories\ProfilNakesRepository;
use Modules\ProfilNakes\Repositories\ProfilNakesUserCacheRepository;

final class ProfilNakesService
{
    public function __construct(
        private readonly ProfilNakesRepository $profilNakesRepository,
        private readonly ProfilNakesMasterDataCacheRepository $masterDataCacheRepository,
        private readonly ProfilNakesUserCacheRepository $userCacheRepository,
    ) {}

    /** @return LengthAwarePaginator<int, ProfilNakes> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        $paginated = $this->profilNakesRepository->paginate($perPage);

        $this->attachDisplayNames($paginated->getCollection());

        return $paginated;
    }

    public function find(int $id): ProfilNakes
    {
        $profilNakes = $this->profilNakesRepository->findById($id);

        abort_if($profilNakes === null, 404, 'Profil nakes tidak ditemukan.');

        $this->attachDisplayNames(collect([$profilNakes]));

        return $profilNakes;
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): ProfilNakes
    {
        $profilNakes = $this->profilNakesRepository->create($data);

        $this->attachDisplayNames(collect([$profilNakes]));
        ProfilNakesCreatedOrUpdated::dispatch($profilNakes->id, $profilNakes->user_nama ?? '');

        return $profilNakes;
    }

    /** @param array<string, mixed> $data */
    public function update(int $id, array $data): ProfilNakes
    {
        $profilNakes = $this->profilNakesRepository->update($this->find($id), $data);

        $this->attachDisplayNames(collect([$profilNakes]));
        ProfilNakesCreatedOrUpdated::dispatch($profilNakes->id, $profilNakes->user_nama ?? '');

        return $profilNakes;
    }

    public function delete(int $id): void
    {
        $this->profilNakesRepository->delete($this->find($id));
    }

    /** @param Collection<int, ProfilNakes> $profilNakesList */
    private function attachDisplayNames(Collection $profilNakesList): void
    {
        if ($profilNakesList->isEmpty()) {
            return;
        }

        $refs = [];
        $userIds = [];

        foreach ($profilNakesList as $profilNakes) {
            $refs[] = ['modul' => 'Profesi', 'id' => $profilNakes->profesi_id];

            if ($profilNakes->poliklinik_id !== null) {
                $refs[] = ['modul' => 'Poliklinik', 'id' => $profilNakes->poliklinik_id];
            }

            $userIds[] = $profilNakes->user_id;
        }

        $namaMasterData = $this->masterDataCacheRepository->fetchNames($refs);
        $userCache = $this->userCacheRepository->fetchMany($userIds);

        foreach ($profilNakesList as $profilNakes) {
            $profilNakes->setAttribute('profesi_nama', $namaMasterData["Profesi:{$profilNakes->profesi_id}"] ?? null);
            $profilNakes->setAttribute(
                'poliklinik_nama',
                $profilNakes->poliklinik_id !== null ? ($namaMasterData["Poliklinik:{$profilNakes->poliklinik_id}"] ?? null) : null,
            );
            $profilNakes->setAttribute('user_nama', $userCache[$profilNakes->user_id]['nama'] ?? null);
            $profilNakes->setAttribute('user_email', $userCache[$profilNakes->user_id]['email'] ?? null);
        }
    }
}
