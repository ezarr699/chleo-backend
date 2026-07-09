<?php
/**
 * ============================================================
 * @module      Pasien
 * @layer       Service
 * @file        PasienService.php
 * @path        Modules/Pasien/Services/PasienService.php
 * @description Business logic Pasien: CRUD, verifikasi (upload foto +
 *              lengkapi data, otomatis set status aktif), toggle status
 *              aktif/nonaktif, dan resolusi nama tampilan lintas modul
 *              (jenis kelamin, golongan darah, asuransi lewat cache lokal;
 *              wilayah lewat WilayahLookupInterface) secara batch supaya
 *              index() tidak N+1 query. create() & update() memicu Global
 *              Event PasienCreatedOrUpdated supaya modul lain (mis.
 *              Billing) bisa menyinkronkan cache lokalnya sendiri — lihat
 *              app/Events/PasienCreatedOrUpdated.php.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Pasien\Services;

use App\Events\PasienCreatedOrUpdated;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Modules\Pasien\Models\Pasien;
use Modules\Pasien\Repositories\PasienMasterDataCacheRepository;
use Modules\Pasien\Repositories\PasienRepository;
use Modules\Shared\Contracts\WilayahLookupInterface;

final class PasienService
{
    public function __construct(
        private readonly PasienRepository $pasienRepository,
        private readonly PasienMasterDataCacheRepository $masterDataCacheRepository,
        private readonly WilayahLookupInterface $wilayahLookup,
    ) {}

    /** @return LengthAwarePaginator<int, Pasien> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        $paginated = $this->pasienRepository->paginate($perPage);

        $this->attachDisplayNames($paginated->getCollection());

        return $paginated;
    }

    public function find(int $id): Pasien
    {
        $pasien = $this->pasienRepository->findById($id);

        abort_if($pasien === null, 404, 'Pasien tidak ditemukan.');

        $this->attachDisplayNames(collect([$pasien]));

        return $pasien;
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Pasien
    {
        $pasien = $this->pasienRepository->create($data);

        $this->publishPasienSnapshot($pasien);
        $this->attachDisplayNames(collect([$pasien]));

        return $pasien;
    }

    /** @param array<string, mixed> $data */
    public function update(int $id, array $data): Pasien
    {
        $pasien = $this->pasienRepository->update($this->find($id), $data);

        $this->publishPasienSnapshot($pasien);
        $this->attachDisplayNames(collect([$pasien]));

        return $pasien;
    }

    /**
     * Pasien saat ini belum punya kolom nomor rekam medis (no_rm) — dikirim
     * null apa adanya. Modul subscriber (mis. Billing) menyimpan kolom itu
     * nullable, siap dipakai begitu no_rm ditambahkan ke modul ini.
     */
    private function publishPasienSnapshot(Pasien $pasien): void
    {
        PasienCreatedOrUpdated::dispatch($pasien->id, $pasien->nama, null, $pasien->nik);
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<int, array{asuransi_id: int, nomor_polis?: string, masa_berlaku?: string}>  $asuransiEntries
     */
    public function verify(int $id, array $data, UploadedFile $foto, array $asuransiEntries = []): Pasien
    {
        $data['foto_path'] = Storage::disk('public')->putFile('pasien', $foto);

        $pasien = $this->pasienRepository->verify($this->find($id), $data, $asuransiEntries);

        $this->attachDisplayNames(collect([$pasien]));

        return $pasien;
    }

    public function setStatus(int $id, bool $aktif): Pasien
    {
        $pasien = $this->find($id);

        abort_if($pasien->verified_at === null, 422, 'Pasien belum diverifikasi.');

        $pasien = $this->pasienRepository->setStatus($pasien, $aktif);

        $this->attachDisplayNames(collect([$pasien]));

        return $pasien;
    }

    public function delete(int $id): void
    {
        $this->pasienRepository->delete($this->find($id));
    }

    /**
     * Resolusi nama tampilan (jenis kelamin, golongan darah, asuransi,
     * wilayah) untuk sekumpulan Pasien dalam query sesedikit mungkin —
     * dipasang sebagai atribut virtual (setAttribute, bukan kolom DB)
     * supaya PasienResource bisa membacanya seperti relasi biasa.
     *
     * @param  Collection<int, Pasien>  $pasienList
     */
    private function attachDisplayNames(Collection $pasienList): void
    {
        if ($pasienList->isEmpty()) {
            return;
        }

        $refs = [];
        $provinsiCodes = [];
        $kabupatenCodes = [];
        $kecamatanCodes = [];
        $kelurahanCodes = [];

        foreach ($pasienList as $pasien) {
            if ($pasien->jenis_kelamin_id !== null) {
                $refs[] = ['modul' => 'JenisKelamin', 'id' => $pasien->jenis_kelamin_id];
            }
            if ($pasien->golongan_darah_id !== null) {
                $refs[] = ['modul' => 'GolonganDarah', 'id' => $pasien->golongan_darah_id];
            }
            foreach ($pasien->asuransiList as $entry) {
                $refs[] = ['modul' => 'Asuransi', 'id' => $entry->asuransi_id];
            }

            if ($pasien->provinsi_code !== null) {
                $provinsiCodes[] = $pasien->provinsi_code;
            }
            if ($pasien->kabupaten_code !== null) {
                $kabupatenCodes[] = $pasien->kabupaten_code;
            }
            if ($pasien->kecamatan_code !== null) {
                $kecamatanCodes[] = $pasien->kecamatan_code;
            }
            if ($pasien->kelurahan_code !== null) {
                $kelurahanCodes[] = $pasien->kelurahan_code;
            }
        }

        $namaMasterData = $this->masterDataCacheRepository->fetchNames($refs);
        $namaProvinsi = $this->wilayahLookup->namaBanyak('provinsi', $provinsiCodes);
        $namaKabupaten = $this->wilayahLookup->namaBanyak('kabupaten', $kabupatenCodes);
        $namaKecamatan = $this->wilayahLookup->namaBanyak('kecamatan', $kecamatanCodes);
        $namaKelurahan = $this->wilayahLookup->namaBanyak('kelurahan', $kelurahanCodes);

        foreach ($pasienList as $pasien) {
            $pasien->setAttribute(
                'jenis_kelamin_nama',
                $pasien->jenis_kelamin_id !== null ? ($namaMasterData["JenisKelamin:{$pasien->jenis_kelamin_id}"] ?? null) : null,
            );
            $pasien->setAttribute(
                'golongan_darah_nama',
                $pasien->golongan_darah_id !== null ? ($namaMasterData["GolonganDarah:{$pasien->golongan_darah_id}"] ?? null) : null,
            );
            $pasien->setAttribute('provinsi_nama', $namaProvinsi[$pasien->provinsi_code] ?? null);
            $pasien->setAttribute('kabupaten_nama', $namaKabupaten[$pasien->kabupaten_code] ?? null);
            $pasien->setAttribute('kecamatan_nama', $namaKecamatan[$pasien->kecamatan_code] ?? null);
            $pasien->setAttribute('kelurahan_nama', $namaKelurahan[$pasien->kelurahan_code] ?? null);

            foreach ($pasien->asuransiList as $entry) {
                $entry->setAttribute('asuransi_nama', $namaMasterData["Asuransi:{$entry->asuransi_id}"] ?? null);
            }
        }
    }
}
