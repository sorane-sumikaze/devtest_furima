<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_items_are_displayed(): void
    {
        $items = Item::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        foreach ($items as $item) {
            $response->assertSee($item->item_name);
        }
    }

    public function test_sold_item_shows_sold_label(): void
    {
        Item::factory()->sold()->create();

        $response = $this->get('/');

        $response->assertSee('Sold');
    }

    public function test_own_items_not_shown_when_authenticated(): void
    {
        $user      = User::factory()->create();
        $ownItem   = Item::factory()->create(['seller_id' => $user->id, 'item_name' => '自分の出品商品ABC']);
        $otherItem = Item::factory()->create(['item_name' => '他のユーザー商品XYZ']);

        $response = $this->actingAs($user)->get('/');

        $response->assertDontSee('自分の出品商品ABC');
        $response->assertSee('他のユーザー商品XYZ');
    }
}
