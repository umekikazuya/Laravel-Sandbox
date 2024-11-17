<?php

namespace App\Services\Interface;

interface ProfileServiceInterface
{
    public function getProfile(): array;

    public function updateProfile(array $data): array;

    public function deleteProfile(): void;
}
