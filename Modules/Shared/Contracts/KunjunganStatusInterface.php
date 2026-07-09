<?php
/**
 * ============================================================
 * @module      Shared
 * @layer       Contract (Interface)
 * @file        KunjunganStatusInterface.php
 * @path        Modules/Shared/Contracts/KunjunganStatusInterface.php
 * @description Kontrak baca/tulis-LANGSUNG (bukan cache-replica) untuk
 *              Kunjungan, dipakai modul lain yang butuh menggerbangi aksi
 *              berdasarkan status Kunjungan SAAT INI (mis. RawatJalan)
 *              atau menulis balik field yang memang didesain diisi
 *              modul bridging (mis. Jkn mengisi no_sep setelah SEP BPJS
 *              berhasil dibuat) — tanpa mengimpor Model Kunjungan (Modul
 *              Registrasi). Diikat lewat
 *              Registrasi\Providers\RegistrasiServiceProvider.
 *              detail() sengaja BUKAN pola cache-replica+event seperti
 *              Billing<->Pasien — status Kunjungan adalah gerbang alur
 *              kerja yang berubah cepat (mis. RawatJalan hanya boleh
 *              membuat Pemeriksaan selagi status masih 'dipanggil');
 *              cache yang di-sync lewat event punya jendela basi
 *              (event belum diproses) yang bisa membuat pemeriksaan
 *              dibuat/ditolak berdasarkan status yang sudah tidak
 *              berlaku — race condition nyata, bukan cuma masalah
 *              arsitektur. Query di implementasinya SELALU langsung ke
 *              tabel kunjungan real-time. updateNoSep() dipakai Jkn
 *              (VClaimService::buatSep()) supaya modul itu tidak pernah
 *              perlu Model Kunjungan sama sekali, baik untuk baca maupun
 *              tulis.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Shared\Contracts;

interface KunjunganStatusInterface
{
    /** @return array{id: int, status: string, no_registrasi: string}|null */
    public function detail(int $kunjunganId): ?array;

    public function updateNoSep(int $kunjunganId, string $noSep): void;
}
