<?php

namespace App\Http\Controllers;

use App\Services\IUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private IUserService $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    public function getUser(Request $request) {
        $userId = auth('sanctum')->user()->id;
        return response()->json($this->userService->getUser($userId));
    }
}
