<?php

namespace App\Http\Controllers;

use App\Services\Implementations\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected ProfileService $service;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }

    public function show(): JsonResponse
    {
        $profile = $this->service->getProfile();

        return response()->json(['data' => $profile]);
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|url',
        ]);

        $profile = $this->service->updateProfile($validated);

        return response()->json(['message' => 'Profile updated successfully', 'data' => $profile]);
    }
}
