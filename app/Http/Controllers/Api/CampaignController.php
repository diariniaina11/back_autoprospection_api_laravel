<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Campaign::query();
        if ($request->has('user_id')) {
            $query->where('user_id', $request->query('user_id'));
        }
        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
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
            'name' => 'required|string|max:255',
            'status' => 'nullable|string',
            'total_contacts' => 'nullable|integer',
            'sent_count' => 'nullable|integer',
            'failed_count' => 'nullable|integer',
        ]);

        $campaign = Campaign::create($validated);

        return response()->json([
            'message' => 'Campaign created successfully',
            'data' => $campaign,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $campaign = Campaign::find($id);
        if (!$campaign) {
            return response()->json(['message' => 'Campaign not found'], 404);
        }
        return response()->json(['data' => $campaign]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $campaign = Campaign::find($id);
        if (!$campaign) {
            return response()->json(['message' => 'Campaign not found'], 404);
        }

        $validated = $request->validate([
            'user_id' => 'nullable|uuid',
            'name' => 'sometimes|required|string|max:255',
            'status' => 'nullable|string',
            'total_contacts' => 'nullable|integer',
            'sent_count' => 'nullable|integer',
            'failed_count' => 'nullable|integer',
        ]);

        $campaign->update($validated);

        return response()->json([
            'message' => 'Campaign updated successfully',
            'data' => $campaign,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $campaign = Campaign::find($id);
        if (!$campaign) {
            return response()->json(['message' => 'Campaign not found'], 404);
        }

        $campaign->delete();

        return response()->json(['message' => 'Campaign deleted successfully']);
    }
}
