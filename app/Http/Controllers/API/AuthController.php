<?php

namespace App\Http\Controllers\API;

use App\Exceptions\AbstractException;
use App\Http\Controllers\Controller;
use App\Models\User;
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

    public function login(Request $request): JsonResponse
    {
        // TODO validation
        try {
            $token = $this->authService->login($request->input('email'), $request->input('password'));
            return response()->json(['token' => $token]);
        } catch (AbstractException $e) {
            return response()->json(['message' => $e->getStatusMessage()])->setStatusCode($e->getStatusCode());
        }
    }

    public function logout(Request $request)
    {
        // TODO validation
        try {
            $this->authService->logout($request->input('user_id'));
            return response()->json('User logged out');
        } catch(AbstractException $e) {
            return response()->json(['message' => $e->getStatusMessage()])->setStatusCode($e->getStatusCode());
        }

    }
}
