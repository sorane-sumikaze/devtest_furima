<?php

namespace App\Services;

use App\Models\Item;
use App\Models\User;

class SellService
{
    public function store(User $user, array $data): Item
    {
        $path = $data['image']->store('items', 'public');

        $item = Item::create([
            'seller_id'   => $user->id,
            'image'       => $path,
            'item_name'   => $data['item_name'],
            'brand_name'  => $data['brand_name'] ?? '',
            'price'       => $data['price'],
            'description' => $data['description'],
            'condition'   => $data['condition'],
            'sold'        => false,
        ]);

        if (!empty($data['categories'])) {
            $item->categories()->sync($data['categories']);
        }

        return $item;
    }
}
