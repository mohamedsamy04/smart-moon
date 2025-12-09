<?php

namespace App\Services;

use App\Actions\Auth\ValidateUserCredentialsAction;
use App\Actions\Auth\LogoutAction;


class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ValidateUserCredentialsAction $validateUserCredentialsAction,
        protected LogoutAction $logoutAction
    ) {
        //
    }

    public function validateCredentials(string $email, string $password)
    {
        $user = $this->validateUserCredentialsAction->execute($email, $password);
        $token = $user->createToken('auth-token')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logout(): bool
    {
        return $this->logoutAction->execute();
    }

}
