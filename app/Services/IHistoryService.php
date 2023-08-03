<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface IHistoryService
{
    /**
     * @param int $userId
     * @return Collection
     */
    public function getHistory(int $userId): Collection;
}
