<?php

namespace App\Http\Controllers;

use App\Exceptions\AbstractException;
use App\Services\IHistoryService;
use Illuminate\Http\JsonResponse;

class HistoryController extends Controller
{
    private IHistoryService $historyService;

    public function __construct(IHistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    /**
     * @return JsonResponse
     */
    public function getHistory(): JsonResponse
    {
        try {
            $userId = auth('sanctum')->user()->id;
            return response()->json($this->historyService->getHistory($userId));
        } catch(AbstractException $exception) {
            return response()->json(['message' => $exception->getStatusMessage()])->setStatusCode($exception->getStatusCode());
        }
    }
}
