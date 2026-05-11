<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_liked_items_are_shown(): void
    {
        $user        = User::factory()->create();
        $likedItem   = Item::factory()->create(['item_name' => 'いいね済み商品AAA']);
        $unlikedItem = Item::factory()->create(['item_name' => 'いいねなし商品BBB']);

        Like::create(['item_id' => $likedItem->id, 'user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertSee('いいね済み商品AAA');
        $response->assertDontSee('いいねなし商品BBB');
    }

    public function test_sold_liked_item_shows_sold_label(): void
    {
        $user     = User::factory()->create();
        $soldItem = Item::factory()->sold()->create();

        Like::create(['item_id' => $soldItem->id, 'user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertSee('Sold');
    }

    public function test_unauthenticated_user_sees_nothing(): void
    {
        $item = Item::factory()->create(['item_name' => '商品表示テストCCC']);

        $response = $this->get('/?tab=mylist');

        $response->assertDontSee('商品表示テストCCC');
    }
}
