<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_partial_match_search(): void
    {
        Item::factory()->create(['item_name' => 'テスト用スポーツシューズ']);
        Item::factory()->create(['item_name' => '関係ない商品YYY']);

        $response = $this->get('/search?keyword=スポーツ');

        $response->assertSee('テスト用スポーツシューズ');
        $response->assertDontSee('関係ない商品YYY');
    }

    public function test_search_keyword_is_preserved_on_mylist_tab(): void
    {
        $user      = User::factory()->create();
        $likedItem = Item::factory()->create(['item_name' => 'マイリストスポーツ商品']);

        Like::create(['item_id' => $likedItem->id, 'user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/search?keyword=スポーツ&tab=mylist');

        $response->assertSee('マイリストスポーツ商品');
        $response->assertSee('スポーツ');
    }
}
