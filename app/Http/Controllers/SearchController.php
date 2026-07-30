<?php

namespace App\Http\Controllers;

use App\Services\Search\SearchService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class SearchController extends BaseController
{
    public function __construct(private SearchService $service)
    {
    }

    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'keyword' => ['nullable', 'string'],
            'sector' => ['nullable'],
            'unit_type' => ['nullable', 'string'],
            'budget' => ['nullable', 'numeric'],
            'area' => ['nullable', 'numeric'],
            'status' => ['nullable'],
            'featured' => ['nullable'],
            'delivery_time' => ['nullable'],
        ]);

        $result = $this->service->search($validated);

        return response()->json([
            'success' => true,
            'execution_time' => $result['execution_time'],
            'total' => $result['total'],
            'results' => $result['results'],
        ]);
    }
}
