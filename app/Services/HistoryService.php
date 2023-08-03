<?php

namespace App\Services;

use App\Exceptions\ProductNotFoundException;
use App\Repositories\IHistoryRepository;
use Illuminate\Database\Eloquent\Collection;

class HistoryService implements IHistoryService
{
    private IHistoryRepository $historyRepository;

    public function __construct(IHistoryRepository $historyRepository)
    {
        $this->historyRepository = $historyRepository;
    }

    /**
     * @param int $userId
     * @return Collection
     * @throws ProductNotFoundException
     */
    public function getHistory(int $userId): Collection
    {
        $products = $this->historyRepository->getUserHistory($userId);
        if (!$products->isEmpty()) {
            return $products;
        }
        throw new ProductNotFoundException();
    }
}
