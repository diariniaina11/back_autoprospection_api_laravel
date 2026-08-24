<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return response()->json(['message' => 'Aucun compte trouvé avec cet email.'], 404);
        }

        return response()->json([
            'message' => 'Connexion réussie',
            'data' => $user,
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:users,email',
            'full_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
        ]);

        $user = User::create($validated);

        return response()->json([
            'message' => 'Compte créé avec succès',
            'data' => $user,
        ], 201);
    }
}
