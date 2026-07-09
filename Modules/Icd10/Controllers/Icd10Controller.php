<?php
/**
 * ============================================================
 * @module      Icd10
 * @layer       Controller
 * @file        Icd10Controller.php
 * @path        Modules/Icd10/Controllers/Icd10Controller.php
 * @description Handle HTTP request untuk data master Icd10: browse
 *              (index, paginated) dan search/autocomplete (RWJ-01-1-1).
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Icd10\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Icd10\Requests\StoreIcd10Request;
use Modules\Icd10\Resources\Icd10Resource;
use Modules\Icd10\Services\Icd10Service;

final class Icd10Controller extends Controller
{
    public function __construct(
        private readonly Icd10Service $icd10Service,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->integer('per_page', 15);
        $paginated = $this->icd10Service->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Data ICD-10 berhasil diambil.',
            'data' => Icd10Resource::collection($paginated->getCollection()),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ],
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'keyword' => ['required', 'string', 'min:2', 'max:255'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $hasil = $this->icd10Service->search($request->string('keyword')->value(), (int) $request->integer('limit', 20));

        return response()->json([
            'success' => true,
            'message' => 'Pencarian ICD-10 berhasil.',
            'data' => Icd10Resource::collection($hasil),
        ]);
    }

    public function store(StoreIcd10Request $request): JsonResponse
    {
        $icd10 = $this->icd10Service->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Kode ICD-10 berhasil ditambahkan.',
            'data' => new Icd10Resource($icd10),
        ], 201);
    }
}
