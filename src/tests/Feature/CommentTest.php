<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_comment(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/items/' . $item->id . '/comments', [
            'comment' => 'テストコメントです',
        ]);

        $this->assertDatabaseHas('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'comment' => 'テストコメントです',
        ]);
    }

    public function test_unauthenticated_user_cannot_comment(): void
    {
        $item = Item::factory()->create();

        $response = $this->post('/items/' . $item->id . '/comments', [
            'comment' => 'テストコメントです',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('comments', ['item_id' => $item->id]);
    }

    public function test_empty_comment_shows_validation_error(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/items/' . $item->id . '/comments', [
            'comment' => '',
        ]);

        $response->assertSessionHasErrors(['comment']);
    }

    public function test_comment_over_255_chars_shows_validation_error(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/items/' . $item->id . '/comments', [
            'comment' => str_repeat('あ', 256),
        ]);

        $response->assertSessionHasErrors(['comment']);
    }
}
