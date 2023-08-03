<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface IHistoryRepository
{
    /**
     * @param int $userId
     * @return Collection
     */
    public function getUserHistory(int $userId): Collection;
}
