<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FollowUp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FollowUpController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = FollowUp::query();
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
            'step' => 'nullable|string',
            'status' => 'nullable|string',
            'template_subject' => 'nullable|string',
            'template_body' => 'nullable|string',
            'scheduled_at' => 'nullable|date',
            'sent_at' => 'nullable|date',
        ]);

        $followUp = FollowUp::create($validated);

        return response()->json([
            'message' => 'FollowUp created successfully',
            'data' => $followUp,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $followUp = FollowUp::find($id);
        if (!$followUp) {
            return response()->json(['message' => 'FollowUp not found'], 404);
        }
        return response()->json(['data' => $followUp]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $followUp = FollowUp::find($id);
        if (!$followUp) {
            return response()->json(['message' => 'FollowUp not found'], 404);
        }

        $validated = $request->validate([
            'prospect_id' => 'nullable|uuid',
            'step' => 'nullable|string',
            'status' => 'nullable|string',
            'template_subject' => 'nullable|string',
            'template_body' => 'nullable|string',
            'scheduled_at' => 'nullable|date',
            'sent_at' => 'nullable|date',
        ]);

        $followUp->update($validated);

        return response()->json([
            'message' => 'FollowUp updated successfully',
            'data' => $followUp,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $followUp = FollowUp::find($id);
        if (!$followUp) {
            return response()->json(['message' => 'FollowUp not found'], 404);
        }

        $followUp->delete();

        return response()->json(['message' => 'FollowUp deleted successfully']);
    }
}
