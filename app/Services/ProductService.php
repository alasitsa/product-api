<?php

namespace App\Services;

use App\Exceptions\IncorrectDataException;
use App\Exceptions\ProductNotFoundException;
use App\Models\Product;
use App\Models\User;
use App\Repositories\IProductRepository;
use App\Repositories\IUserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class ProductService implements IProductService
{
    private IProductRepository $productRepository;
    private IUserRepository $userRepository;

    public function __construct(IProductRepository $productRepository, IUserRepository $userRepository)
    {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $user
     * @param int $itemId
     * @param int $time
     * @return void
     * @throws IncorrectDataException
     * @throws ProductNotFoundException
     */
    public function extendRent(User $user, int $itemId, int $time): void
    {
        $item = $this->getItem($user->id, $itemId);
        $totalPrice = $time * $item->rent_price;
        if ($user->money < $totalPrice) {
            throw new IncorrectDataException();
        }
        $currentExpiration = strtotime($item->pivot->expires_at);
        $currentTime = now()->timestamp;
        if (($currentExpiration - $currentTime) + $time * 3600 > 24 * 3600) {
            throw new IncorrectDataException();
        }
        $expiresAt = Carbon::createFromTimestamp($currentExpiration + $time * 3600);
        $this->productRepository->updatePivot($user->id, $itemId, ['expires_at' => $expiresAt]);
        $this->userRepository->updateUser($user->id, [
            'money' => $user->money - $totalPrice
        ]);
    }

    /**
     * @param User $user
     * @param int $productId
     * @param int $time
     * @return void
     * @throws IncorrectDataException
     * @throws ProductNotFoundException
     */
    public function rent(User $user, int $productId, int $time): void
    {
        $product = $this->get($productId);
        $currentTime = now()->timestamp;
        $totalPrice = $product->rent_price * $time;
        if ($user->money < $totalPrice) {
            throw new IncorrectDataException();
        }
        if ($time > 24) {
            throw new IncorrectDataException();
        }
        $expiresAt = Carbon::createFromTimestamp($currentTime + $time * 3600);
        $this->productRepository->addPivot($user->id, $productId, ['expires_at' => $expiresAt]);
        $this->userRepository->updateUser($user->id, [
            'money' => $user->money - $totalPrice
        ]);
    }

    /**
     * @param User $user
     * @param int $productId
     * @return void
     * @throws IncorrectDataException
     * @throws ProductNotFoundException
     */
    public function buy(User $user, int $productId): void
    {
        $product = $this->get($productId);
        if ($user->money < $product->price) {
            throw new IncorrectDataException();
        }
        $this->productRepository->addPivot($user->id, $productId);
        $this->userRepository->updateUser($user->id, [
            'money' => $user->money - $product->price
        ]);
    }

    /**
     * @return Collection
     * @throws ProductNotFoundException
     */
    public function getAll(): Collection
    {
        $products = $this->productRepository->getAll();
        if (!$products->isEmpty()) {
            return $products;
        }
        throw new ProductNotFoundException();
    }

    /**
     * @param int $id
     * @return Product
     * @throws ProductNotFoundException
     */
    public function get(int $id): Product
    {
        $product = $this->productRepository->get($id);
        if ($product) {
            return $product;
        }
        throw new ProductNotFoundException();
    }

    /**
     * @param int $userId
     * @return Collection
     * @throws ProductNotFoundException
     */
    public function getUserProducts(int $userId): Collection
    {
        $products = $this->productRepository->getUserItems($userId);
        if (!$products->isEmpty()) {
            return $products;
        }
        throw new ProductNotFoundException();
    }

    /**
     * @param int $userId
     * @param int $itemId
     * @return Product
     * @throws ProductNotFoundException
     */
    public function getItem(int $userId, int $itemId): Product
    {
        $item = $this->productRepository->getItem($userId, $itemId);
        if ($item) {
            return $item;
        }
        throw new ProductNotFoundException();
    }
}
