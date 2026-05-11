<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    // condition: 1=良好, 2=目立った傷や汚れなし, 3=やや傷や汚れあり, 4=状態が悪い
    private const ITEMS = [
        [
            'item_name'   => '腕時計',
            'price'       => 15000,
            'brand_name'  => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image'       => 'items/watch.jpg',
            'condition'   => 1,
        ],
        [
            'item_name'   => 'HDD',
            'price'       => 5000,
            'brand_name'  => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'image'       => 'items/hdd.jpg',
            'condition'   => 2,
        ],
        [
            'item_name'   => '玉ねぎ3束',
            'price'       => 300,
            'brand_name'  => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'image'       => 'items/onion.jpg',
            'condition'   => 3,
        ],
        [
            'item_name'   => '革靴',
            'price'       => 4000,
            'brand_name'  => '',
            'description' => 'クラシックなデザインの革靴',
            'image'       => 'items/leather_shoes.jpg',
            'condition'   => 4,
        ],
        [
            'item_name'   => 'ノートPC',
            'price'       => 45000,
            'brand_name'  => '',
            'description' => '高性能なノートパソコン',
            'image'       => 'items/laptop.jpg',
            'condition'   => 1,
        ],
        [
            'item_name'   => 'マイク',
            'price'       => 8000,
            'brand_name'  => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'image'       => 'items/mic.jpg',
            'condition'   => 2,
        ],
        [
            'item_name'   => 'ショルダーバッグ',
            'price'       => 3500,
            'brand_name'  => '',
            'description' => 'おしゃれなショルダーバッグ',
            'image'       => 'items/shoulder_bag.jpg',
            'condition'   => 3,
        ],
        [
            'item_name'   => 'タンブラー',
            'price'       => 500,
            'brand_name'  => 'なし',
            'description' => '使いやすいタンブラー',
            'image'       => 'items/tumbler.jpg',
            'condition'   => 4,
        ],
        [
            'item_name'   => 'コーヒーミル',
            'price'       => 4000,
            'brand_name'  => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'image'       => 'items/coffee_mill.jpg',
            'condition'   => 1,
        ],
        [
            'item_name'   => 'メイクセット',
            'price'       => 2500,
            'brand_name'  => '',
            'description' => '便利なメイクアップセット',
            'image'       => 'items/makeup_set.jpg',
            'condition'   => 2,
        ],
    ];

    public function run(): void
    {
        foreach (self::ITEMS as $data) {
            Item::create([
                'seller_id'   => 1,
                'item_name'   => $data['item_name'],
                'price'       => $data['price'],
                'brand_name'  => $data['brand_name'],
                'description' => $data['description'],
                'image'       => $data['image'],
                'condition'   => $data['condition'],
                'sold'        => false,
            ]);
        }
    }
}
