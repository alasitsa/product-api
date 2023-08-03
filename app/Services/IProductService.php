<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface IProductService
{
    public function extendRent(User $user, int $itemId, int $time): void;
    public function rent(User $userId, int $productId, int $time): void;
    public function buy(User $userId, int $productId): void;
    public function getAll(): Collection;
    public function get(int $id): Product;
    public function getUserProducts(int $userId): Collection;
}
