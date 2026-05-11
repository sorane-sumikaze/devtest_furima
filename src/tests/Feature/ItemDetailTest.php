<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_detail_shows_required_info(): void
    {
        $item = Item::factory()->create([
            'item_name'  => '詳細表示テスト商品',
            'brand_name' => 'テストブランド',
            'price'      => 3000,
            'description' => '商品説明テキスト',
        ]);

        $response = $this->get('/items/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee('詳細表示テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('3,000');
        $response->assertSee('商品説明テキスト');
    }

    public function test_multiple_categories_are_displayed(): void
    {
        $cat1 = Category::create(['name' => 'カテゴリA']);
        $cat2 = Category::create(['name' => 'カテゴリB']);
        $item = Item::factory()->create();
        $item->categories()->attach([$cat1->id, $cat2->id]);

        $response = $this->get('/items/' . $item->id);

        $response->assertSee('カテゴリA');
        $response->assertSee('カテゴリB');
    }
}
