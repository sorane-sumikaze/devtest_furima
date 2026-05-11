<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class MypageService
{
    public function getSoldItems(User $user): Collection
    {
        return $user->items()->get();
    }

    public function getPurchasedItems(User $user): Collection
    {
        return $user->purchases()->with('item')->get()->pluck('item')->filter()->values();
    }
}
