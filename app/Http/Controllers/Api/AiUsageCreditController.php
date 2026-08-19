<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AiUsageCredit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiUsageCreditController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = AiUsageCredit::query();
        if ($request->has('user_id')) {
            $query->where('user_id', $request->query('user_id'));
        }
        if ($request->boolean('paginate')) {
            return response()->json($query->paginate($request->query('per_page', 15)));
        }
        return response()->json($query->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'nullable|uuid',
            'credits_allocated' => 'nullable|integer',
            'credits_used' => 'nullable|integer',
            'last_reset_at' => 'nullable|date',
        ]);

        $credit = AiUsageCredit::create($validated);

        return response()->json([
            'message' => 'AiUsageCredit created successfully',
            'data' => $credit,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $credit = AiUsageCredit::find($id);
        if (!$credit) {
            return response()->json(['message' => 'AiUsageCredit not found'], 404);
        }
        return response()->json(['data' => $credit]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $credit = AiUsageCredit::find($id);
        if (!$credit) {
            return response()->json(['message' => 'AiUsageCredit not found'], 404);
        }

        $validated = $request->validate([
            'user_id' => 'nullable|uuid',
            'credits_allocated' => 'nullable|integer',
            'credits_used' => 'nullable|integer',
            'last_reset_at' => 'nullable|date',
        ]);

        $credit->update($validated);

        return response()->json([
            'message' => 'AiUsageCredit updated successfully',
            'data' => $credit,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $credit = AiUsageCredit::find($id);
        if (!$credit) {
            return response()->json(['message' => 'AiUsageCredit not found'], 404);
        }

        $credit->delete();

        return response()->json(['message' => 'AiUsageCredit deleted successfully']);
    }
}
