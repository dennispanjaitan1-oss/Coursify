<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    public function deleted(User $user): void
    {
        if ($user->avatar_url) {
            $path = str_replace('storage/', '', $user->avatar_url);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $legacyPath = public_path($user->avatar_url);
            if (file_exists($legacyPath)) {
                @unlink($legacyPath);
            }
        }
    }
}
