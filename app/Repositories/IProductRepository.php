<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface IProductRepository
{
    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param int $id
     * @return Product|null
     */
    public function get(int $id): Product|null;

    /**
     * @param int $userId
     * @return Collection
     */
    public function getUserItems(int $userId): Collection;

    /**
     * @param int $userId
     * @param int $itemId
     * @param array $params
     * @return void
     */
    public function updatePivot(int $userId, int $itemId, array $params = []): void;

    /**
     * @param int $userId
     * @param int $itemId
     * @return Product|null
     */
    public function getItem(int $userId, int $itemId): Product|null;

    /**
     * @param int $userId
     * @param int $productId
     * @param array $params
     * @return void
     */
    public function addPivot(int $userId, int $productId, array $params = []): void;
}
