<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Test::query();
        if ($request->boolean('paginate')) {
            return response()->json($query->paginate($request->query('per_page', 15)));
        }
        return response()->json($query->get());
    }

    public function store(Request $request): JsonResponse
    {
        $test = Test::create();

        return response()->json([
            'message' => 'Test record created successfully',
            'data' => $test,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $test = Test::find($id);
        if (!$test) {
            return response()->json(['message' => 'Test record not found'], 404);
        }
        return response()->json(['data' => $test]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $test = Test::find($id);
        if (!$test) {
            return response()->json(['message' => 'Test record not found'], 404);
        }

        $test->touch();

        return response()->json([
            'message' => 'Test record updated successfully',
            'data' => $test,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $test = Test::find($id);
        if (!$test) {
            return response()->json(['message' => 'Test record not found'], 404);
        }

        $test->delete();

        return response()->json(['message' => 'Test record deleted successfully']);
    }
}
