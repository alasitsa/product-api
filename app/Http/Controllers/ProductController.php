<?php

namespace App\Http\Controllers;

use App\Exceptions\AbstractException;
use App\Http\Requests\BuyRequest;
use App\Http\Requests\ExtendRentRequest;
use App\Http\Requests\RentRequest;
use App\Services\IProductService;
use App\Services\IUserService;
use Illuminate\Http\JsonResponse;

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
     * @param RentRequest $request
     * @return JsonResponse
     */
    public function rent(RentRequest $request): JsonResponse
    {
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
     * @param ExtendRentRequest $request
     * @return JsonResponse
     */
    public function extendRent(ExtendRentRequest $request): JsonResponse
    {
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
     * @param BuyRequest $request
     * @return JsonResponse
     */
    public function buy(BuyRequest $request): JsonResponse
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
        try {
            return response()->json($this->productService->getAll());
        } catch (AbstractException $exception) {
            return response()->json(['message' => $exception->getStatusMessage()])->setStatusCode($exception->getStatusCode());
        }

    }

    /**
     * @return JsonResponse
     */
    public function getUserProducts(): JsonResponse
    {
        try {
            $userId = auth('sanctum')->user()->id;
            return response()->json($this->productService->getUserProducts($userId));
        } catch (AbstractException $exception) {
            return response()->json(['message' => $exception->getStatusMessage()])->setStatusCode($exception->getStatusCode());
        }
    }
}
