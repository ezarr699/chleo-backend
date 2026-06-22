<?php
/**
 * ============================================================
 * @module      MasterData
 * @layer       Controller
 * @file        AbstractMasterDataController.php
 * @path        app/Support/MasterData/AbstractMasterDataController.php
 * @description HTTP handler generik untuk data master. index()/destroy()
 *              langsung dipakai dari sini karena tidak butuh body request
 *              ter-validasi. store()/update() TIDAK didefinisikan di sini
 *              (PHP tidak bisa narrow tipe parameter Request di method
 *              override) — setiap modul mendefinisikan store()/update()
 *              sendiri yang type-hint ke FormRequest miliknya, lalu
 *              memanggil handleStore()/handleUpdate() di bawah ini.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Support\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class AbstractMasterDataController extends Controller
{
    abstract protected function service(): AbstractMasterDataService;

    /** @return class-string<MasterDataResource> */
    abstract protected function resourceClass(): string;

    abstract protected function label(): string;

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->integer('per_page', 15);
        $paginated = $this->service()->paginate($perPage);
        $resourceClass = $this->resourceClass();

        return response()->json([
            'success' => true,
            'message' => "Data {$this->label()} berhasil diambil.",
            'data' => $resourceClass::collection($paginated->getCollection()),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ],
        ]);
    }

    /** @param array<string, mixed> $validated */
    protected function handleStore(array $validated): JsonResponse
    {
        $model = $this->service()->create($validated);
        $resourceClass = $this->resourceClass();

        return response()->json([
            'success' => true,
            'message' => "{$this->label()} berhasil dibuat.",
            'data' => new $resourceClass($model),
        ], 201);
    }

    /** @param array<string, mixed> $validated */
    protected function handleUpdate(int $id, array $validated): JsonResponse
    {
        $model = $this->service()->update($id, $validated);
        $resourceClass = $this->resourceClass();

        return response()->json([
            'success' => true,
            'message' => "{$this->label()} berhasil diperbarui.",
            'data' => new $resourceClass($model),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service()->delete($id);

        return response()->json([
            'success' => true,
            'message' => "{$this->label()} berhasil dihapus.",
            'data' => null,
        ]);
    }
}
