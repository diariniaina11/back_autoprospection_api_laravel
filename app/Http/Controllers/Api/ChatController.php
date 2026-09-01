<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Chat::query();

        if ($request->has('user_uuid')) {
            $query->where('user_uuid', $request->query('user_uuid'));
        }

        if ($request->has('suspect_uuid')) {
            $query->where('suspect_uuid', $request->query('suspect_uuid'));
        }

        $query->orderBy('created_at', 'asc');

        if ($request->boolean('paginate')) {
            return response()->json($query->paginate($request->query('per_page', 15)));
        }

        return response()->json($query->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_uuid'    => 'nullable|uuid',
            'suspect_uuid' => 'nullable|uuid',
            'email'        => 'nullable|array',
        ]);

        $chat = Chat::create($validated);

        return response()->json([
            'message' => 'Chat created successfully',
            'data'    => $chat,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $chat = Chat::find($id);

        if (!$chat) {
            return response()->json(['message' => 'Chat not found'], 404);
        }

        return response()->json(['data' => $chat]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $chat = Chat::find($id);

        if (!$chat) {
            return response()->json(['message' => 'Chat not found'], 404);
        }

        $validated = $request->validate([
            'user_uuid'    => 'nullable|uuid',
            'suspect_uuid' => 'nullable|uuid',
            'email'        => 'nullable|array',
        ]);

        $chat->update($validated);

        return response()->json([
            'message' => 'Chat updated successfully',
            'data'    => $chat,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $chat = Chat::find($id);

        if (!$chat) {
            return response()->json(['message' => 'Chat not found'], 404);
        }

        $chat->delete();

        return response()->json(['message' => 'Chat deleted successfully']);
    }

    /**
     * DEBUG TEMPORAIRE : retourne les colonnes et la valeur brute sans accesseur.
     * Accès : GET /api/chats/debug/raw
     */
    public function debugRaw(): JsonResponse
    {
        $row = \DB::table('chats')->first();
        return response()->json([
            'columns' => $row ? array_keys((array) $row) : [],
            'raw_row' => $row,
        ]);
    }
}
