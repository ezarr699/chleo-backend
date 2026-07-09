<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Service
 * @file        RegistrasiService.php
 * @path        Modules/Registrasi/Services/RegistrasiService.php
 * @description Business logic Registrasi: membuat kunjungan walk-in
 *              (REG-01-1), rujukan masuk/keluar (REG-01-2), dan online
 *              booking (REG-01-3), serta transisi status antrian
 *              (panggil/selesai/batal/checkin). Penomoran
 *              (no_registrasi/no_antrian) didelegasikan ke Repository,
 *              di sini hanya aturan transisi status dan validasi
 *              lintas-field (profil_nakes harus praktik di poliklinik
 *              yang dipilih — lewat ProfilNakesLookupInterface, LIVE
 *              read bukan cache, karena penugasan nakes-poliklinik bisa
 *              berubah dan validasi registrasi wajib pakai data
 *              ter-update; kunjungan yang sudah selesai/batal/dirujuk
 *              tidak bisa dirujuk keluar lagi, booking harus 'terjadwal'
 *              dulu sebelum bisa checkin). Juga meresolusi nama tampilan
 *              lintas modul (pasien, poliklinik, profil nakes, penjamin,
 *              registered_by) lewat cache lokal secara batch supaya
 *              index() tidak N+1 query.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Registrasi\Models\Kunjungan;
use Modules\Registrasi\Repositories\RegistrasiMasterDataCacheRepository;
use Modules\Registrasi\Repositories\RegistrasiPasienCacheRepository;
use Modules\Registrasi\Repositories\RegistrasiRepository;
use Modules\Shared\Contracts\ProfilNakesLookupInterface;

final class RegistrasiService
{
    public function __construct(
        private readonly RegistrasiRepository $registrasiRepository,
        private readonly RegistrasiMasterDataCacheRepository $masterDataCacheRepository,
        private readonly RegistrasiPasienCacheRepository $pasienCacheRepository,
        private readonly ProfilNakesLookupInterface $profilNakesLookup,
    ) {}

    /** @return LengthAwarePaginator<int, Kunjungan> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        $paginated = $this->registrasiRepository->paginate($perPage);

        $this->attachDisplayNames($paginated->getCollection());

        return $paginated;
    }

    public function find(int $id): Kunjungan
    {
        $kunjungan = $this->registrasiRepository->findById($id);

        abort_if($kunjungan === null, 404, 'Kunjungan tidak ditemukan.');

        $this->attachDisplayNames(collect([$kunjungan]));

        return $kunjungan;
    }

    /** @param array<string, mixed> $data */
    public function createWalkIn(array $data): Kunjungan
    {
        $this->assertProfilNakesSesuaiPoliklinik($data);

        $kunjungan = $this->registrasiRepository->createWalkIn($data);
        $this->attachDisplayNames(collect([$kunjungan]));

        return $kunjungan;
    }

    /** @param array<string, mixed> $data */
    public function createRujukanMasuk(array $data): Kunjungan
    {
        $this->assertProfilNakesSesuaiPoliklinik($data);

        $kunjungan = $this->registrasiRepository->createRujukanMasuk($data);
        $this->attachDisplayNames(collect([$kunjungan]));

        return $kunjungan;
    }

    /** @param array<string, mixed> $data */
    public function rujukKeluar(int $id, array $data): Kunjungan
    {
        $kunjungan = $this->find($id);

        abort_if(
            in_array($kunjungan->status, ['selesai', 'batal', 'dirujuk'], true),
            422,
            'Kunjungan yang sudah selesai/batal/dirujuk tidak bisa dirujuk keluar lagi.'
        );

        $kunjungan = $this->registrasiRepository->rujukKeluar($kunjungan, $data);
        $this->attachDisplayNames(collect([$kunjungan]));

        return $kunjungan;
    }

    /** @param array<string, mixed> $data */
    public function createBooking(array $data): Kunjungan
    {
        $this->assertProfilNakesSesuaiPoliklinik($data);

        $kunjungan = $this->registrasiRepository->createBooking($data);
        $this->attachDisplayNames(collect([$kunjungan]));

        return $kunjungan;
    }

    public function checkin(int $id): Kunjungan
    {
        $kunjungan = $this->find($id);

        abort_if($kunjungan->status !== 'terjadwal', 422, 'Kunjungan tidak dalam status terjadwal (booking).');

        $kunjungan = $this->registrasiRepository->checkin($kunjungan);
        $this->attachDisplayNames(collect([$kunjungan]));

        return $kunjungan;
    }

    public function panggil(int $id): Kunjungan
    {
        $kunjungan = $this->find($id);

        abort_if($kunjungan->status !== 'menunggu', 422, 'Kunjungan tidak dalam status menunggu.');

        $kunjungan = $this->registrasiRepository->panggil($kunjungan);
        $this->attachDisplayNames(collect([$kunjungan]));

        return $kunjungan;
    }

    public function selesai(int $id): Kunjungan
    {
        $kunjungan = $this->find($id);

        abort_if(! in_array($kunjungan->status, ['menunggu', 'dipanggil'], true), 422, 'Kunjungan tidak bisa diselesaikan dari status saat ini.');

        $kunjungan = $this->registrasiRepository->selesai($kunjungan);
        $this->attachDisplayNames(collect([$kunjungan]));

        return $kunjungan;
    }

    public function batal(int $id, string $alasan): Kunjungan
    {
        $kunjungan = $this->find($id);

        abort_if(in_array($kunjungan->status, ['selesai', 'batal'], true), 422, 'Kunjungan yang sudah selesai/batal tidak bisa dibatalkan lagi.');

        $kunjungan = $this->registrasiRepository->batal($kunjungan, $alasan);
        $this->attachDisplayNames(collect([$kunjungan]));

        return $kunjungan;
    }

    /** @param array<string, mixed> $data */
    private function assertProfilNakesSesuaiPoliklinik(array $data): void
    {
        if (empty($data['profil_nakes_id'])) {
            return;
        }

        $sesuaiPoli = $this->profilNakesLookup->praktikDiPoliklinik(
            (int) $data['profil_nakes_id'],
            (int) $data['poliklinik_id'],
        );

        abort_if(! $sesuaiPoli, 422, 'Nakes yang dipilih tidak praktik di poliklinik tersebut.');
    }

    /** @param Collection<int, Kunjungan> $kunjunganList */
    private function attachDisplayNames(Collection $kunjunganList): void
    {
        if ($kunjunganList->isEmpty()) {
            return;
        }

        $refs = [];
        $pasienIds = [];

        foreach ($kunjunganList as $kunjungan) {
            $refs[] = ['modul' => 'Poliklinik', 'id' => $kunjungan->poliklinik_id];
            $refs[] = ['modul' => 'Penjamin', 'id' => $kunjungan->penjamin_id];

            if ($kunjungan->profil_nakes_id !== null) {
                $refs[] = ['modul' => 'ProfilNakes', 'id' => $kunjungan->profil_nakes_id];
            }
            if ($kunjungan->registered_by !== null) {
                $refs[] = ['modul' => 'User', 'id' => $kunjungan->registered_by];
            }

            $pasienIds[] = $kunjungan->pasien_id;
        }

        $namaMasterData = $this->masterDataCacheRepository->fetchNames($refs);
        $pasienCache = $this->pasienCacheRepository->fetchMany($pasienIds);

        foreach ($kunjunganList as $kunjungan) {
            $kunjungan->setAttribute('pasien_nik', $pasienCache[$kunjungan->pasien_id]['nik'] ?? null);
            $kunjungan->setAttribute('pasien_nama', $pasienCache[$kunjungan->pasien_id]['nama'] ?? null);
            $kunjungan->setAttribute('poliklinik_nama', $namaMasterData["Poliklinik:{$kunjungan->poliklinik_id}"] ?? null);
            $kunjungan->setAttribute('penjamin_nama', $namaMasterData["Penjamin:{$kunjungan->penjamin_id}"] ?? null);
            $kunjungan->setAttribute(
                'profil_nakes_nama',
                $kunjungan->profil_nakes_id !== null ? ($namaMasterData["ProfilNakes:{$kunjungan->profil_nakes_id}"] ?? null) : null,
            );
            $kunjungan->setAttribute(
                'registered_by_nama',
                $kunjungan->registered_by !== null ? ($namaMasterData["User:{$kunjungan->registered_by}"] ?? null) : null,
            );
        }
    }
}
