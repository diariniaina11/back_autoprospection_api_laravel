<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = User::query();
        if ($request->boolean('paginate')) {
            return response()->json($query->paginate($request->query('per_page', 15)));
        }
        return response()->json($query->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'full_name' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
        ]);

        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['data' => $user]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'email' => 'sometimes|required|email|max:255',
            'full_name' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
