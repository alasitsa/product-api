<?php

namespace App\Http\Controllers;

use App\Exceptions\AbstractException;
use App\Services\IProductService;
use App\Services\IUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private IProductService $productService;
    private IUserService $userService;

    public function __construct(IProductService $productService, IUserService $userService)
    {
        $this->productService = $productService;
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function rent(Request $request): JsonResponse
    {
        // TODO validation
        try {
            $userId = auth('sanctum')->user()->id;
            $user = $this->userService->getUser($userId);
            $this->productService->rent($user, $request->input('product_id'), $request->input('time'));
            return response()->json(["message" => "Successfully rented"]);
        } catch (AbstractException $exception) {
            return response()->json(['message' => $exception->getStatusMessage()])->setStatusCode($exception->getStatusCode());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function extendRent(Request $request): JsonResponse
    {
        // TODO validation
        try { // item id is pivot id
            $userId = auth('sanctum')->user()->id;
            $user = $this->userService->getUser($userId);
            $this->productService->extendRent($user, $request->input('item_id'), $request->input('time'));
            return response()->json(["message" => "Successfully rented"]);
        } catch (AbstractException $exception) {
            return response()->json(['message' => $exception->getStatusMessage()])->setStatusCode($exception->getStatusCode());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function buy(Request $request): JsonResponse
    {
        try {
            $userId = auth('sanctum')->user()->id;
            $user = $this->userService->getUser($userId);
            $this->productService->buy($user, $request->input('product_id'));
            return response()->json(["message" => "Successfully bought"]);
        } catch (AbstractException $exception) {
            return response()->json(['message' => $exception->getStatusMessage()])->setStatusCode($exception->getStatusCode());
        }
    }

    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        return response()->json($this->productService->getAll());
    }

    /**
     * @return JsonResponse
     */
    public function getUserProducts(): JsonResponse
    {
        $userId = auth('sanctum')->user()->id;
        return response()->json($this->productService->getUserProducts($userId));
    }
}
