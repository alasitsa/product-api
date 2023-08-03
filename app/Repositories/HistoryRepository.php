<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

class HistoryRepository implements IHistoryRepository
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getUserHistory(int $userId): Collection
    {
        return $this->userRepository->getUser($userId)->products()->withPivot('id', 'expires_at')->getResults();
    }
}
