<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    public function purchase(Item $item, User $user, int $paymentMethod, array $shipping = []): void
    {
        DB::transaction(function () use ($item, $user, $paymentMethod, $shipping) {
            $fresh = Item::lockForUpdate()->findOrFail($item->id);

            if ($fresh->sold) {
                throw new \RuntimeException('この商品はすでに購入されています');
            }

            Purchase::create([
                'user_id'        => $user->id,
                'item_id'        => $fresh->id,
                'payment_method' => $paymentMethod,
                'ship_post_code' => $shipping['ship_post_code'] ?? $user->post_code,
                'ship_address'   => $shipping['ship_address']   ?? $user->address,
                'ship_building'  => $shipping['ship_building']  ?? $user->building,
            ]);

            $fresh->sold = true;
            $fresh->save();
        });
    }
}
