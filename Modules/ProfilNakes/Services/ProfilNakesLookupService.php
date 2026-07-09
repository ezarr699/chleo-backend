<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Service
 * @file        ProfilNakesLookupService.php
 * @path        Modules/ProfilNakes/Services/ProfilNakesLookupService.php
 * @description Implementasi Shared\Contracts\ProfilNakesLookupInterface —
 *              satu-satunya jalur modul lain (mis. Registrasi, RawatJalan)
 *              boleh memvalidasi penugasan nakes-poliklinik atau membaca
 *              nama nakes, tanpa pernah mengimpor Model ProfilNakes/User
 *              secara langsung. namaLengkap() memakai
 *              ProfilNakesUserCacheRepository (bukan query User::class
 *              langsung) karena Model User memang bukan milik modul ini.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\ProfilNakes\Services;

use Modules\ProfilNakes\Models\ProfilNakes;
use Modules\ProfilNakes\Repositories\ProfilNakesUserCacheRepository;
use Modules\Shared\Contracts\ProfilNakesLookupInterface;

final class ProfilNakesLookupService implements ProfilNakesLookupInterface
{
    public function __construct(
        private readonly ProfilNakesUserCacheRepository $userCacheRepository,
    ) {}

    public function praktikDiPoliklinik(int $profilNakesId, int $poliklinikId): bool
    {
        return ProfilNakes::query()
            ->whereKey($profilNakesId)
            ->where('poliklinik_id', $poliklinikId)
            ->exists();
    }

    public function namaLengkap(int $profilNakesId): ?string
    {
        $profilNakes = ProfilNakes::query()->find($profilNakesId, ['id', 'user_id']);

        if ($profilNakes === null) {
            return null;
        }

        $userCache = $this->userCacheRepository->fetchMany([$profilNakes->user_id]);

        return $userCache[$profilNakes->user_id]['nama'] ?? null;
    }
}
