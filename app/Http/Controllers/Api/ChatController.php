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

        if ($request->has('user_id')) {
            $query->where('user_id', $request->query('user_id'));
        }

        if ($request->has('prospect_id')) {
            $query->where('prospect_id', $request->query('prospect_id'));
        }

        if ($request->has('sender')) {
            $query->where('sender', $request->query('sender'));
        }

        if ($request->has('is_read')) {
            $query->where('is_read', filter_var($request->query('is_read'), FILTER_VALIDATE_BOOLEAN));
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
            'user_id'     => 'nullable|uuid',
            'prospect_id' => 'nullable|uuid',
            'sender'      => 'nullable|string|max:255',
            'message'     => 'required|string',
            'is_read'     => 'nullable|boolean',
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
            'user_id'     => 'nullable|uuid',
            'prospect_id' => 'nullable|uuid',
            'sender'      => 'nullable|string|max:255',
            'message'     => 'sometimes|required|string',
            'is_read'     => 'nullable|boolean',
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
