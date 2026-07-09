<?php
/**
 * ============================================================
 * @module      Registrasi
 * @layer       Controller
 * @file        RegistrasiController.php
 * @path        Modules/Registrasi/Controllers/RegistrasiController.php
 * @description Handle HTTP request untuk registrasi kunjungan pasien:
 *              walk-in (REG-01-1), rujukan masuk/keluar (REG-01-2),
 *              online booking Mobile JKN/Web Portal (REG-01-3), dan
 *              transisi status antrian (checkin/panggil/selesai/batal).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Registrasi\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Registrasi\Requests\BatalRegistrasiRequest;
use Modules\Registrasi\Requests\StoreBookingRequest;
use Modules\Registrasi\Requests\StoreRegistrasiRequest;
use Modules\Registrasi\Requests\StoreRujukanKeluarRequest;
use Modules\Registrasi\Requests\StoreRujukanMasukRequest;
use Modules\Registrasi\Resources\RegistrasiResource;
use Modules\Registrasi\Services\RegistrasiService;

final class RegistrasiController extends Controller
{
    public function __construct(
        private readonly RegistrasiService $registrasiService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->integer('per_page', 15);
        $paginated = $this->registrasiService->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Daftar kunjungan berhasil diambil.',
            'data' => RegistrasiResource::collection($paginated->getCollection()),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ],
        ]);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail kunjungan berhasil diambil.',
            'data' => new RegistrasiResource($this->registrasiService->find($id)),
        ]);
    }

    public function store(StoreRegistrasiRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['registered_by'] = $request->user()?->id;

        $kunjungan = $this->registrasiService->createWalkIn($data);

        return response()->json([
            'success' => true,
            'message' => 'Kunjungan berhasil didaftarkan.',
            'data' => new RegistrasiResource($kunjungan),
        ], 201);
    }

    public function rujukanMasuk(StoreRujukanMasukRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['registered_by'] = $request->user()?->id;

        $kunjungan = $this->registrasiService->createRujukanMasuk($data);

        return response()->json([
            'success' => true,
            'message' => 'Kunjungan rujukan masuk berhasil didaftarkan.',
            'data' => new RegistrasiResource($kunjungan),
        ], 201);
    }

    public function rujukanKeluar(StoreRujukanKeluarRequest $request, int $id): JsonResponse
    {
        $kunjungan = $this->registrasiService->rujukKeluar($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Kunjungan berhasil dirujuk keluar.',
            'data' => new RegistrasiResource($kunjungan),
        ]);
    }

    public function booking(StoreBookingRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['registered_by'] = $request->user()?->id;

        $kunjungan = $this->registrasiService->createBooking($data);

        return response()->json([
            'success' => true,
            'message' => 'Booking kunjungan berhasil dibuat.',
            'data' => new RegistrasiResource($kunjungan),
        ], 201);
    }

    public function checkin(int $id): JsonResponse
    {
        $kunjungan = $this->registrasiService->checkin($id);

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil, pasien masuk antrian.',
            'data' => new RegistrasiResource($kunjungan),
        ]);
    }

    public function panggil(int $id): JsonResponse
    {
        $kunjungan = $this->registrasiService->panggil($id);

        return response()->json([
            'success' => true,
            'message' => 'Pasien berhasil dipanggil.',
            'data' => new RegistrasiResource($kunjungan),
        ]);
    }

    public function selesai(int $id): JsonResponse
    {
        $kunjungan = $this->registrasiService->selesai($id);

        return response()->json([
            'success' => true,
            'message' => 'Kunjungan berhasil diselesaikan.',
            'data' => new RegistrasiResource($kunjungan),
        ]);
    }

    public function batal(BatalRegistrasiRequest $request, int $id): JsonResponse
    {
        $kunjungan = $this->registrasiService->batal($id, $request->validated()['alasan_batal']);

        return response()->json([
            'success' => true,
            'message' => 'Kunjungan berhasil dibatalkan.',
            'data' => new RegistrasiResource($kunjungan),
        ]);
    }
}
