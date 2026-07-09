<?php
/**
 * ============================================================
 * @module      IntegrationLog
 * @layer       Controller
 * @file        IntegrationLogController.php
 * @path        Modules/IntegrationLog/Controllers/IntegrationLogController.php
 * @description Handle HTTP request dashboard admin monitoring error
 *              bridging (INT-01): list+filter, detail, dan transisi
 *              resolusi (investigate/resolve).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\IntegrationLog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\IntegrationLog\Requests\ResolveIntegrationLogRequest;
use Modules\IntegrationLog\Resources\IntegrationLogResource;
use Modules\IntegrationLog\Services\IntegrationLogService;

final class IntegrationLogController extends Controller
{
    public function __construct(
        private readonly IntegrationLogService $integrationLogService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['integrasi', 'level', 'status_resolusi']);
        $perPage = (int) $request->integer('per_page', 15);
        $paginated = $this->integrationLogService->paginate($filters, $perPage);

        return response()->json([
            'success' => true,
            'message' => 'Daftar log integrasi berhasil diambil.',
            'data' => IntegrationLogResource::collection($paginated->getCollection()),
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
            'message' => 'Detail log integrasi berhasil diambil.',
            'data' => new IntegrationLogResource($this->integrationLogService->find($id)),
        ]);
    }

    public function investigate(int $id): JsonResponse
    {
        $log = $this->integrationLogService->investigate($id);

        return response()->json([
            'success' => true,
            'message' => 'Log integrasi sedang diinvestigasi.',
            'data' => new IntegrationLogResource($log),
        ]);
    }

    public function resolve(ResolveIntegrationLogRequest $request, int $id): JsonResponse
    {
        $log = $this->integrationLogService->resolve(
            $id,
            $request->validated()['catatan_resolusi'],
            $request->user()->id,
        );

        return response()->json([
            'success' => true,
            'message' => 'Log integrasi berhasil di-resolve.',
            'data' => new IntegrationLogResource($log),
        ]);
    }
}
