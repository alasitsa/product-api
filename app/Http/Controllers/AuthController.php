<?php

namespace App\Http\Controllers;

use App\Exceptions\AbstractException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Services\IAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private IAuthService $authService;

    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $token = $this->authService->login($request->input('email'), $request->input('password'));
            return response()->json(['token' => $token]);
        } catch (AbstractException $e) {
            return response()->json(['message' => $e->getStatusMessage()])->setStatusCode($e->getStatusCode());
        }
    }

    /**
     * @param LogoutRequest $request
     * @return JsonResponse
     */
    public function logout(LogoutRequest $request)
    {
        try {
            $this->authService->logout($request->input('user_id'));
            return response()->json('User logged out');
        } catch(AbstractException $e) {
            return response()->json(['message' => $e->getStatusMessage()])->setStatusCode($e->getStatusCode());
        }

    }
}
