<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ColdEmailModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ColdEmailModelController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = ColdEmailModel::query();
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
            'name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $model = ColdEmailModel::create($validated);

        return response()->json([
            'message' => 'ColdEmailModel created successfully',
            'data' => $model,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $model = ColdEmailModel::find($id);
        if (!$model) {
            return response()->json(['message' => 'ColdEmailModel not found'], 404);
        }
        return response()->json(['data' => $model]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $model = ColdEmailModel::find($id);
        if (!$model) {
            return response()->json(['message' => 'ColdEmailModel not found'], 404);
        }

        $validated = $request->validate([
            'user_id' => 'nullable|uuid',
            'category_id' => 'nullable|uuid',
            'name' => 'sometimes|required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $model->update($validated);

        return response()->json([
            'message' => 'ColdEmailModel updated successfully',
            'data' => $model,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $model = ColdEmailModel::find($id);
        if (!$model) {
            return response()->json(['message' => 'ColdEmailModel not found'], 404);
        }

        $model->delete();

        return response()->json(['message' => 'ColdEmailModel deleted successfully']);
    }
}
