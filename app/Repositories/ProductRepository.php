<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements IProductRepository
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Product::all();
    }

    /**
     * @param int $id
     * @return Product|null
     */
    public function get(int $id): Product|null
    {
        return Product::find($id);
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getUserItems(int $userId): Collection
    {
        return $this->userRepository->getUser($userId)->products()
            ->withPivot('id', 'expires_at')
            ->whereNested(function ($query) {
                $query->where('expires_at', '>', now());
                $query->orWhereNull('expires_at');
            })
            ->getResults();
    }

    /**
     * @param int $userId
     * @param int $itemId
     * @param array $params
     * @return void
     */
    public function updatePivot(int $userId, int $itemId, array $params = []): void
    {
//        $products = $this->getUserItems($userId);
//        $product = $products->first(function ($product) use ($itemId) {
//            if ($product->pivot->id == $itemId) {
//                return true;
//            }
//            return false;
//        });

        $product = $this->getItem($userId, $itemId);

        foreach ($params as $field => $value) {
            $product->pivot[$field] = $value;
        }
        $product->pivot->save();
    }

    /**
     * @param int $userId
     * @param int $itemId
     * @return Product|null
     */
    public function getItem(int $userId, int $itemId): Product|null
    {
        return $this->getUserItems($userId)
            ->first(function ($item) use ($itemId) {
                if ($item->pivot->id == $itemId) {
                    return true;
                }
                return false;
            });
    }

    /**
     * @param int $userId
     * @param int $productId
     * @param array $params
     * @return void
     */
    public function addPivot(int $userId, int $productId, array $params = []): void
    {
        $user = $this->userRepository->getUser($userId);
        $pivotParams = [
            'user_id' => $userId,
            'product_id' => $productId
        ];

        foreach ($params as $field => $value) {
            $pivotParams[$field] = $value;
        }
        $user->products()->newPivot($pivotParams)->save();

    }
}
