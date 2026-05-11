<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemService
{
    public function getRecommendedItems()
    {
        $userId = Auth::id();

        return Item::when($userId, function ($query) use ($userId) {
            $query->where('seller_id', '!=', $userId);
        })->get();
    }

    public function getMyListItems()
    {
        $userId = Auth::id();

        if (!$userId) {
            return collect();
        }

        return Item::whereHas('likes', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }

    public function getItemDetail(Item $item): Item
    {
        return $item->load(['categories', 'comments.user', 'likes', 'seller']);
    }

    public function search(string $keyword, string $tab)
    {
        $escaped = str_replace(
            ['\\', '%', '_'],
            ['\\\\', '\%', '\_'],
            $keyword
        );
        $userId = Auth::id();

        if ($tab === 'mylist') {
            if (!$userId) {
                return collect();
            }
            return Item::whereHas('likes', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('item_name', 'like', "%{$escaped}%")->get();
        }

        return Item::when($userId, function ($query) use ($userId) {
            $query->where('seller_id', '!=', $userId);
        })->where('item_name', 'like', "%{$escaped}%")->get();
    }
}
