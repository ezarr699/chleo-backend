<?php
/**
 * ============================================================
 * @module      Wilayah
 * @layer       Controller
 * @file        WilayahController.php
 * @path        Modules/Wilayah/Controllers/WilayahController.php
 * @description Lookup data wilayah administratif Indonesia (provinsi,
 *              kabupaten/kota, kecamatan, kelurahan/desa) bersumber dari
 *              laravolt/indonesia di database central. Murni baca-saja
 *              untuk mengisi dropdown berjenjang alamat pasien — tidak
 *              ada Service/Repository terpisah karena tidak ada business
 *              logic, hanya pass-through query ke model central.
 *              `kabupaten()` sengaja membuat query param `provinsi`
 *              opsional (`when()`, bukan `where()` wajib) — dipakai dua
 *              cara oleh frontend: berjenjang (dengan `provinsi`) untuk
 *              dropdown alamat, dan nasional tanpa filter (tanpa
 *              `provinsi`) untuk pilihan Tempat Lahir di dialog verifikasi
 *              pasien, yang tidak terikat ke provinsi alamat saat ini.
 *              ~514 baris kabupaten/kota se-Indonesia, aman di-fetch utuh.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * @ref         https://github.com/laravolt/indonesia
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Wilayah\Controllers;

use App\Http\Controllers\Controller;
use Modules\Wilayah\Models\Kabupaten;
use Modules\Wilayah\Models\Kecamatan;
use Modules\Wilayah\Models\Kelurahan;
use Modules\Wilayah\Models\Provinsi;
use Modules\Wilayah\Services\WilayahDeteksiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class WilayahController extends Controller
{
    public function __construct(
        private readonly WilayahDeteksiService $wilayahDeteksiService,
    ) {}

    public function provinsi(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Daftar provinsi berhasil diambil.',
            'data' => Provinsi::query()->orderBy('name')->get(['code', 'name']),
        ]);
    }

    public function kabupaten(Request $request): JsonResponse
    {
        $provinsiCode = $request->query('provinsi');

        return response()->json([
            'success' => true,
            'message' => 'Daftar kabupaten/kota berhasil diambil.',
            'data' => Kabupaten::query()
                ->when($provinsiCode, fn ($query) => $query->where('province_code', $provinsiCode))
                ->orderBy('name')
                ->get(['code', 'name']),
        ]);
    }

    public function kecamatan(Request $request): JsonResponse
    {
        $kabupatenCode = (string) $request->query('kabupaten', '');

        return response()->json([
            'success' => true,
            'message' => 'Daftar kecamatan berhasil diambil.',
            'data' => Kecamatan::query()
                ->where('city_code', $kabupatenCode)
                ->orderBy('name')
                ->get(['code', 'name']),
        ]);
    }

    public function kelurahan(Request $request): JsonResponse
    {
        $kecamatanCode = (string) $request->query('kecamatan', '');

        return response()->json([
            'success' => true,
            'message' => 'Daftar kelurahan/desa berhasil diambil.',
            'data' => Kelurahan::query()
                ->where('district_code', $kecamatanCode)
                ->orderBy('name')
                ->get(['code', 'name']),
        ]);
    }

    public function deteksiLokasi(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $result = $this->wilayahDeteksiService->detect((float) $validated['lat'], (float) $validated['lng']);

        $toRef = fn (?object $model) => $model ? ['code' => $model->code, 'name' => $model->name] : null;

        return response()->json([
            'success' => true,
            'message' => $result['provinsi'] === null
                ? 'Lokasi tidak dapat dicocokkan ke data wilayah, silakan pilih manual.'
                : 'Lokasi berhasil dideteksi.',
            'data' => [
                'provinsi' => $toRef($result['provinsi']),
                'kabupaten' => $toRef($result['kabupaten']),
                'kecamatan' => $toRef($result['kecamatan']),
                'kelurahan' => $toRef($result['kelurahan']),
            ],
        ]);
    }
}
