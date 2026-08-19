<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SentEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SentEmailController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = SentEmail::query();
        if ($request->has('campaign_id')) {
            $query->where('campaign_id', $request->query('campaign_id'));
        }
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
            'campaign_id' => 'nullable|uuid',
            'prospect_id' => 'nullable|uuid',
            'model_id' => 'nullable|uuid',
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'status' => 'nullable|string',
            'error_message' => 'nullable|string',
            'sent_at' => 'nullable|date',
        ]);

        $sentEmail = SentEmail::create($validated);

        return response()->json([
            'message' => 'SentEmail created successfully',
            'data' => $sentEmail,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $sentEmail = SentEmail::find($id);
        if (!$sentEmail) {
            return response()->json(['message' => 'SentEmail not found'], 404);
        }
        return response()->json(['data' => $sentEmail]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $sentEmail = SentEmail::find($id);
        if (!$sentEmail) {
            return response()->json(['message' => 'SentEmail not found'], 404);
        }

        $validated = $request->validate([
            'campaign_id' => 'nullable|uuid',
            'prospect_id' => 'nullable|uuid',
            'model_id' => 'nullable|uuid',
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'status' => 'nullable|string',
            'error_message' => 'nullable|string',
            'sent_at' => 'nullable|date',
        ]);

        $sentEmail->update($validated);

        return response()->json([
            'message' => 'SentEmail updated successfully',
            'data' => $sentEmail,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $sentEmail = SentEmail::find($id);
        if (!$sentEmail) {
            return response()->json(['message' => 'SentEmail not found'], 404);
        }

        $sentEmail->delete();

        return response()->json(['message' => 'SentEmail deleted successfully']);
    }
}
