<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prospect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProspectController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Prospect::query();
        if ($request->has('user_id')) {
            $query->where('user_id', $request->query('user_id'));
        }
        if ($request->has('category_id')) {
            $query->where('category_id', $request->query('category_id'));
        }
        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
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
            'suspect_id' => 'nullable|uuid',
            'category_id' => 'nullable|uuid',
            'name' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'source' => 'nullable|string',
            'status' => 'nullable|string',
            'added_at' => 'nullable|date',
        ]);

        $prospect = Prospect::create($validated);

        return response()->json([
            'message' => 'Prospect created successfully',
            'data' => $prospect,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $prospect = Prospect::find($id);
        if (!$prospect) {
            return response()->json(['message' => 'Prospect not found'], 404);
        }
        return response()->json(['data' => $prospect]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $prospect = Prospect::find($id);
        if (!$prospect) {
            return response()->json(['message' => 'Prospect not found'], 404);
        }

        $validated = $request->validate([
            'user_id' => 'nullable|uuid',
            'suspect_id' => 'nullable|uuid',
            'category_id' => 'nullable|uuid',
            'name' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'source' => 'nullable|string',
            'status' => 'nullable|string',
            'added_at' => 'nullable|date',
        ]);

        $prospect->update($validated);

        return response()->json([
            'message' => 'Prospect updated successfully',
            'data' => $prospect,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $prospect = Prospect::find($id);
        if (!$prospect) {
            return response()->json(['message' => 'Prospect not found'], 404);
        }

        $prospect->delete();

        return response()->json(['message' => 'Prospect deleted successfully']);
    }
}
