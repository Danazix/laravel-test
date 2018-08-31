<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\ApiAuthService;
use Illuminate\Http\JsonResponse;
use Response;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @param ApiAuthService $authService
     * @return JsonResponse
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function login(LoginRequest $request, ApiAuthService $authService): JsonResponse
    {
        return Response::json(['token' => $authService->login($request->validated())]);
    }

    /**
     * @param ApiAuthService $authService
     * @param User $user
     */
    public function logout(ApiAuthService $authService): void
    {
        $authService->logout(\Auth::id());
    }
}
