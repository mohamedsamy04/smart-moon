<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {
        //
    }

    public function login(LoginRequest $request)
    {
        $data = $this->authService->validateCredentials($request->email, $request->password);
        return response()->json([
            'message' => 'Login successful.',
            'data' => $data
        ], 200);
    }

    public function logout(): JsonResponse
    {
        $success = $this->authService->logout();

        if (!$success) {
            return response()->json(['error' => 'User not logged in'], 401);
        }

        return response()->json(['message' => 'Logged out successfully']);
    }
}
