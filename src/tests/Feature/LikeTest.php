<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_like_increases_count(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/items/' . $item->id . '/likes');

        $this->assertDatabaseHas('likes', ['item_id' => $item->id, 'user_id' => $user->id]);
        $this->assertEquals(1, $item->fresh()->likes()->count());
    }

    public function test_liked_item_shows_color_change(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Like::create(['item_id' => $item->id, 'user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/items/' . $item->id);

        $response->assertSee('like-btn--active', false);
    }

    public function test_unlike_decreases_count(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/items/' . $item->id . '/likes');
        $this->assertEquals(1, $item->fresh()->likes()->count());

        $this->actingAs($user)->post('/items/' . $item->id . '/likes');
        $this->assertEquals(0, $item->fresh()->likes()->count());
    }
}
