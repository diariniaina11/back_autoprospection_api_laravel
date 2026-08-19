<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Suspect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SuspectController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Suspect::query();
        if ($request->has('user_id')) {
            $query->where('user_id', $request->query('user_id'));
        }
        if ($request->has('category_id')) {
            $query->where('category_id', $request->query('category_id'));
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
            'category_id' => 'nullable|uuid',
            'name' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'source' => 'nullable|string',
            'status' => 'nullable|string',
            'detected_at' => 'nullable|date',
        ]);

        $suspect = Suspect::create($validated);

        return response()->json([
            'message' => 'Suspect created successfully',
            'data' => $suspect,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $suspect = Suspect::find($id);
        if (!$suspect) {
            return response()->json(['message' => 'Suspect not found'], 404);
        }
        return response()->json(['data' => $suspect]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $suspect = Suspect::find($id);
        if (!$suspect) {
            return response()->json(['message' => 'Suspect not found'], 404);
        }

        $validated = $request->validate([
            'user_id' => 'nullable|uuid',
            'category_id' => 'nullable|uuid',
            'name' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'source' => 'nullable|string',
            'status' => 'nullable|string',
            'detected_at' => 'nullable|date',
        ]);

        $suspect->update($validated);

        return response()->json([
            'message' => 'Suspect updated successfully',
            'data' => $suspect,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $suspect = Suspect::find($id);
        if (!$suspect) {
            return response()->json(['message' => 'Suspect not found'], 404);
        }

        $suspect->delete();

        return response()->json(['message' => 'Suspect deleted successfully']);
    }
}
