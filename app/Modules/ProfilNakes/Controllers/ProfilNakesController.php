<?php
/**
 * ============================================================
 * @module      ProfilNakes
 * @layer       Controller
 * @file        ProfilNakesController.php
 * @path        app/Modules/ProfilNakes/Controllers/ProfilNakesController.php
 * @description Handle HTTP request untuk resource ProfilNakes (CRUD).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Modules\ProfilNakes\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Modules\ProfilNakes\Requests\StoreProfilNakesRequest;
use App\Modules\ProfilNakes\Requests\UpdateProfilNakesRequest;
use App\Modules\ProfilNakes\Resources\ProfilNakesResource;
use App\Modules\ProfilNakes\Services\ProfilNakesService;

final class ProfilNakesController extends Controller
{
    public function __construct(
        private readonly ProfilNakesService $profilNakesService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->integer('per_page', 15);
        $paginated = $this->profilNakesService->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Daftar profil nakes berhasil diambil.',
            'data' => ProfilNakesResource::collection($paginated->getCollection()),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ],
        ]);
    }

    public function store(StoreProfilNakesRequest $request): JsonResponse
    {
        $profilNakes = $this->profilNakesService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Profil nakes berhasil dibuat.',
            'data' => new ProfilNakesResource($profilNakes),
        ], 201);
    }

    public function update(UpdateProfilNakesRequest $request, int $id): JsonResponse
    {
        $profilNakes = $this->profilNakesService->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Profil nakes berhasil diperbarui.',
            'data' => new ProfilNakesResource($profilNakes),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->profilNakesService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Profil nakes berhasil dihapus.',
            'data' => null,
        ]);
    }
}
