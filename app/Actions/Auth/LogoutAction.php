<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class LogoutAction
{
    public function execute(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        // لو بتستخدم Sanctum Tokens (API tokens)
        if ($user instanceof User) {
            $token = $user->currentAccessToken();
            if ($token instanceof PersonalAccessToken) {
                $token->forceDelete();
            }
        }

        return true;
    }
}
