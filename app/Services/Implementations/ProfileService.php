<?php

namespace App\Services\Implementations;

use App\Models\Profile;
use App\Services\Interface\ProfileServiceInterface;

class ProfileService implements ProfileServiceInterface
{
    public function getProfile(): array
    {
        return Profile::findOrCreate();
    }

    public function updateProfile(array $data): array
    {
        $profile = Profile::find(Profile::getKey());

        if (! $profile) {
            throw new \Exception('Profile not found.');
        }

        $profile = array_merge($profile, [
            'Name' => ['S' => $data['name']],
            'Title' => ['S' => $data['title']],
            'Bio' => ['S' => $data['bio']],
            'Avatar' => ['S' => $data['avatar']],
            'UpdatedAt' => ['S' => now()->toIso8601String()],
        ]);

        Profile::save($profile);

        return $profile;
    }

    public function deleteProfile(): void
    {
        // No script.
    }
}
