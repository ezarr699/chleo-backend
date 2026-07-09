<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Repository
 * @file        RegistrasiRepository.php
 * @path        Modules/Registrasi/Repositories/RegistrasiRepository.php
 * @description Akses data Kunjungan + penomoran no_registrasi/no_antrian.
 *              Penomoran dibuat lewat tabel counter terpisah
 *              (urutan_registrasi_harian, urutan_antrian_poliklinik)
 *              yang di-lock (SELECT ... FOR UPDATE) di dalam transaksi
 *              DB, supaya aman dari race condition saat banyak loket
 *              mendaftar bersamaan. Logika antrianPrefix yang dulu ada
 *              di sini dipindah ke PoliklinikLookupInterface (pengetahuan
 *              milik Modul Poliklinik, bukan Registrasi). Eager-load
 *              relasi hanya rujukan (modul sendiri) — nama tampilan
 *              pasien/poliklinik/profilNakes/penjamin/registeredBy
 *              diresolusi RegistrasiService lewat cache lokal.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Registrasi\Models\Kunjungan;
use Modules\Registrasi\Models\KunjunganRujukan;
use Modules\Shared\Contracts\PoliklinikLookupInterface;

final class RegistrasiRepository
{
    private const RELATIONS = ['rujukan'];

    private const RUJUKAN_MASUK_FIELDS = [
        'asal_faskes_kode', 'asal_faskes_nama',
        'nomor_rujukan_sisrute', 'nomor_rujukan_bpjs',
        'diagnosa_rujukan', 'catatan_rujukan', 'tanggal_rujukan',
    ];

    private const RUJUKAN_KELUAR_FIELDS = [
        'tujuan_faskes_kode', 'tujuan_faskes_nama',
        'nomor_rujukan_sisrute', 'nomor_rujukan_bpjs',
        'diagnosa_rujukan', 'catatan_rujukan', 'tanggal_rujukan',
    ];

    public function __construct(
        private readonly PoliklinikLookupInterface $poliklinikLookup,
    ) {}

    /** @return LengthAwarePaginator<int, Kunjungan> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Kunjungan::query()
            ->with(self::RELATIONS)
            ->latest('tanggal_kunjungan')
            ->latest('angka_antrian')
            ->paginate($perPage);
    }

    public function findById(int $id): ?Kunjungan
    {
        return Kunjungan::query()->with(self::RELATIONS)->find($id);
    }

    /** @param array<string, mixed> $data */
    public function createWalkIn(array $data): Kunjungan
    {
        return $this->createKunjungan($data, 'walk_in');
    }

    /** @param array<string, mixed> $data */
    public function createBooking(array $data): Kunjungan
    {
        return $this->createKunjungan($data, 'online_booking', 'terjadwal');
    }

    public function checkin(Kunjungan $kunjungan): Kunjungan
    {
        $kunjungan->update(['status' => 'menunggu']);

        return $kunjungan->fresh(self::RELATIONS);
    }

    /** @param array<string, mixed> $data */
    public function createRujukanMasuk(array $data): Kunjungan
    {
        return DB::transaction(function () use ($data) {
            $rujukanData = array_intersect_key($data, array_flip(self::RUJUKAN_MASUK_FIELDS));

            $kunjungan = $this->createKunjungan($data, 'rujukan');

            KunjunganRujukan::create([
                ...$rujukanData,
                'kunjungan_id' => $kunjungan->id,
                'arah' => 'masuk',
                'tanggal_rujukan' => $data['tanggal_rujukan'] ?? $kunjungan->tanggal_kunjungan,
            ]);

            return $kunjungan->load(self::RELATIONS);
        });
    }

    /** @param array<string, mixed> $data */
    public function rujukKeluar(Kunjungan $kunjungan, array $data): Kunjungan
    {
        return DB::transaction(function () use ($kunjungan, $data) {
            $rujukanData = array_intersect_key($data, array_flip(self::RUJUKAN_KELUAR_FIELDS));

            KunjunganRujukan::create([
                ...$rujukanData,
                'kunjungan_id' => $kunjungan->id,
                'arah' => 'keluar',
                'tanggal_rujukan' => $data['tanggal_rujukan'] ?? now()->toDateString(),
            ]);

            $kunjungan->update(['status' => 'dirujuk']);

            return $kunjungan->fresh(self::RELATIONS);
        });
    }

    /** @param array<string, mixed> $data */
    private function createKunjungan(array $data, string $caraMasuk, string $status = 'menunggu'): Kunjungan
    {
        return DB::transaction(function () use ($data, $caraMasuk, $status) {
            $tanggal = Carbon::parse($data['tanggal_kunjungan'] ?? now())->toDateString();
            $poliklinikId = (int) $data['poliklinik_id'];

            $urutanHarian = $this->nextUrutanHarian($tanggal);
            $angkaAntrian = $this->nextAngkaAntrian($tanggal, $poliklinikId);
            $prefix = $this->poliklinikLookup->antrianPrefix($poliklinikId);

            return Kunjungan::create([
                ...$data,
                'cara_masuk' => $caraMasuk,
                'tanggal_kunjungan' => $tanggal,
                'urutan_harian' => $urutanHarian,
                'no_registrasi' => sprintf('REG-%s-%04d', Carbon::parse($tanggal)->format('Ymd'), $urutanHarian),
                'angka_antrian' => $angkaAntrian,
                'no_antrian' => sprintf('%s-%03d', $prefix, $angkaAntrian),
                'status' => $status,
            ])->load(self::RELATIONS);
        });
    }

    public function panggil(Kunjungan $kunjungan): Kunjungan
    {
        $kunjungan->update(['status' => 'dipanggil']);

        return $kunjungan->fresh(self::RELATIONS);
    }

    public function selesai(Kunjungan $kunjungan): Kunjungan
    {
        $kunjungan->update(['status' => 'selesai']);

        return $kunjungan->fresh(self::RELATIONS);
    }

    public function batal(Kunjungan $kunjungan, string $alasan): Kunjungan
    {
        $kunjungan->update(['status' => 'batal', 'alasan_batal' => $alasan]);

        return $kunjungan->fresh(self::RELATIONS);
    }

    private function nextUrutanHarian(string $tanggal): int
    {
        DB::table('urutan_registrasi_harian')->insertOrIgnore([
            'tanggal' => $tanggal,
            'urutan' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $urutan = DB::table('urutan_registrasi_harian')
            ->where('tanggal', $tanggal)
            ->lockForUpdate()
            ->value('urutan');

        $next = $urutan + 1;

        DB::table('urutan_registrasi_harian')->where('tanggal', $tanggal)->update(['urutan' => $next]);

        return $next;
    }

    private function nextAngkaAntrian(string $tanggal, int $poliklinikId): int
    {
        DB::table('urutan_antrian_poliklinik')->insertOrIgnore([
            'tanggal' => $tanggal,
            'poliklinik_id' => $poliklinikId,
            'urutan' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $urutan = DB::table('urutan_antrian_poliklinik')
            ->where('tanggal', $tanggal)
            ->where('poliklinik_id', $poliklinikId)
            ->lockForUpdate()
            ->value('urutan');

        $next = $urutan + 1;

        DB::table('urutan_antrian_poliklinik')
            ->where('tanggal', $tanggal)
            ->where('poliklinik_id', $poliklinikId)
            ->update(['urutan' => $next]);

        return $next;
    }
}
