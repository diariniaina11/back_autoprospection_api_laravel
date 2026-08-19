<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MessageThread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageThreadController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = MessageThread::query();
        if ($request->has('reply_id')) {
            $query->where('reply_id', $request->query('reply_id'));
        }
        if ($request->boolean('paginate')) {
            return response()->json($query->paginate($request->query('per_page', 15)));
        }
        return response()->json($query->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'reply_id' => 'nullable|uuid',
            'sender' => 'nullable|string',
            'text' => 'nullable|string',
            'sent_at' => 'nullable|date',
        ]);

        $thread = MessageThread::create($validated);

        return response()->json([
            'message' => 'MessageThread created successfully',
            'data' => $thread,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $thread = MessageThread::find($id);
        if (!$thread) {
            return response()->json(['message' => 'MessageThread not found'], 404);
        }
        return response()->json(['data' => $thread]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $thread = MessageThread::find($id);
        if (!$thread) {
            return response()->json(['message' => 'MessageThread not found'], 404);
        }

        $validated = $request->validate([
            'reply_id' => 'nullable|uuid',
            'sender' => 'nullable|string',
            'text' => 'nullable|string',
            'sent_at' => 'nullable|date',
        ]);

        $thread->update($validated);

        return response()->json([
            'message' => 'MessageThread updated successfully',
            'data' => $thread,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $thread = MessageThread::find($id);
        if (!$thread) {
            return response()->json(['message' => 'MessageThread not found'], 404);
        }

        $thread->delete();

        return response()->json(['message' => 'MessageThread deleted successfully']);
    }
}
