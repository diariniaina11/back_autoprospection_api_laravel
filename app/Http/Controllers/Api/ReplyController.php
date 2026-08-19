<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reply;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Reply::query();
        if ($request->has('prospect_id')) {
            $query->where('prospect_id', $request->query('prospect_id'));
        }
        if ($request->boolean('paginate')) {
            return response()->json($query->paginate($request->query('per_page', 15)));
        }
        return response()->json($query->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'prospect_id' => 'nullable|uuid',
            'sent_email_id' => 'nullable|uuid',
            'category' => 'nullable|string',
            'subject' => 'nullable|string|max:255',
            'preview' => 'nullable|string',
            'message' => 'nullable|string',
            'received_at' => 'nullable|date',
        ]);

        $reply = Reply::create($validated);

        return response()->json([
            'message' => 'Reply created successfully',
            'data' => $reply,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $reply = Reply::find($id);
        if (!$reply) {
            return response()->json(['message' => 'Reply not found'], 404);
        }
        return response()->json(['data' => $reply]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $reply = Reply::find($id);
        if (!$reply) {
            return response()->json(['message' => 'Reply not found'], 404);
        }

        $validated = $request->validate([
            'prospect_id' => 'nullable|uuid',
            'sent_email_id' => 'nullable|uuid',
            'category' => 'nullable|string',
            'subject' => 'nullable|string|max:255',
            'preview' => 'nullable|string',
            'message' => 'nullable|string',
            'received_at' => 'nullable|date',
        ]);

        $reply->update($validated);

        return response()->json([
            'message' => 'Reply updated successfully',
            'data' => $reply,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $reply = Reply::find($id);
        if (!$reply) {
            return response()->json(['message' => 'Reply not found'], 404);
        }

        $reply->delete();

        return response()->json(['message' => 'Reply deleted successfully']);
    }
}
